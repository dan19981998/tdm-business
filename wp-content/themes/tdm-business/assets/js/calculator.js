document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("earningsForm");
    const steps = Array.from(document.querySelectorAll(".step"));
    const indicators = Array.from(document.querySelectorAll(".step-indicator .step-num"));
    const separators = Array.from(document.querySelectorAll(".step-indicator .step-sep"));
    const resultEl = document.getElementById("result");
    const workSlider = document.getElementById("workEthicSlider");
    const looksSlider = document.getElementById("looksSlider");
    const recalculateButtonContainer = document.getElementById('recalculateButtonContainer');
    const recalculateButton = document.getElementById('recalculateButton');
    let current = 0;

    function showStep(i) {
        steps.forEach((fs, idx) => fs.style.display = idx === i ? "block" : "none");
        
        indicators.forEach((el, idx) => {
            el.classList.toggle("active", idx === i);
            el.classList.toggle("visited", idx < i);
        });

        separators.forEach((sep, idx) => {
            sep.classList.toggle("before-active", idx < i);
        });

        document.querySelectorAll(".prev").forEach(btn => {
            btn.style.display = (i === steps.length - 1) ? "none" : "inline-block";
        });
        
        if (i !== steps.length - 1) { 
            recalculateButtonContainer.style.display = 'none';
            recalculateButtonContainer.style.opacity = '0';
        }
    }

    function updateWorkEthicText(v) {
        v = +v;
        const msg = v <= 2 ? "Poor work ethic"
            : v <= 4 ? "Needs improvement"
                : v <= 6 ? "Moderate work ethic"
                    : v <= 8 ? "Strong work ethic"
                        : "Exceptional work ethic";
        document.getElementById("workEthicMessage").textContent = msg;
    }

    function updateLooksText(v) {
        v = +v;
        const msg = v <= 2 ? "Very Unattractive"
            : v <= 4 ? "Unattractive"
                : v <= 6 ? "Average"
                    : v <= 8 ? "Attractive"
                        : "Stunning";
        document.getElementById("looksMessage").textContent = msg;
    }

    showStep(current); 
    updateWorkEthicText(workSlider.value);
    updateLooksText(looksSlider.value);

    document.querySelectorAll(".next").forEach(btn =>
        btn.addEventListener("click", () => {
            if (current < steps.length - 1) {
                current++;
                showStep(current);
                if (current === steps.length - 1) {
                    form.dispatchEvent(new Event("submit", { cancelable: true }));
                }
            }
        })
    );

    document.querySelectorAll(".prev").forEach(btn =>
        btn.addEventListener("click", () => {
            if (current > 0) {
                current--;
                showStep(current);
            }
        })
    );

    workSlider.addEventListener("input", () => {
        form.workEthic.value = workSlider.value;
        updateWorkEthicText(workSlider.value);
    });
    looksSlider.addEventListener("input", () => {
        form.looks.value = looksSlider.value;
        updateLooksText(looksSlider.value);
    });

    form.addEventListener("submit", e => {
        e.preventDefault();

        resultEl.style.display = "none";
        const loadContainer = document.getElementById("loadingContainer");
        loadContainer.style.display = "block";
        const loadingAnim = lottie.loadAnimation({
            container: loadContainer,
            renderer: "svg",
            loop: true,
            autoplay: true,
            path: tdm_paths.lottiePath + 'loading.json'
        });

        const data = {
            action: "calculate_earnings",
            age: form.age.value,
            following: form.following.value,
            branding: form.branding.value,
            location: form.location.value,
            management: form.management.value,
            traffic: form.traffic.value,
            looks: form.looks.value,
            workEthic: form.workEthic.value,
            speaksEnglish: form.speaksEnglish.value,
            explicit: form.explicit.value,
            custom: form.custom.value
        };

        fetch(ajax_object.ajaxurl, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams(data)
        })
            .then(r => r.json())
            .then(json => {
                loadingAnim.destroy();
                loadContainer.style.display = "none";

                if (!json.success) {
                    const err = json.data?.error || "Unknown error";
                    resultEl.innerHTML = `<p style="color:red;">${err}</p>`;
                    resultEl.style.display = "block";
                    return;
                }

                const p = json.data;
                const username = p.instagramData.username || "N/A";
                const fullName = p.fullName;
                const followerCount = p.followerCount;
                const estimatedEarnings = p.estimatedEarnings;
                const { label, title, description } = getIncomeCategory(estimatedEarnings);

                resultEl.innerHTML = `
                <div class="results-content">
                  <div class="nameAndFollowrCount">
                    <p class="name">${fullName}</p>
                    <p class="instagram-followers">
                      <strong>Instagram Followers:</strong> ${followerCount}
                    </p>
                  </div>
                  <div class="calculation">
                  <div class="creator-stats">
                    <div class="earnings">
                      <span class="blue">$</span><span id="earnings-counter">${estimatedEarnings}</span>
                  </div>
                      <div class="earnings-description">
                    <h3>Potential Monthly Earnings:</h3>
                    <p>This is the amount of money your page should be making.</p>
                    </div>
                   </div>
                  <div class="creator-stats">
                    <div class="model-potential">
                      ${label}
                    </div>
                  <p class="tier-title">${title}</p> 
                    <p class="tier-description">${description}</p>
                </div>
                </div>
                </div>
              `;
                resultEl.style.display = "block";

                const els = resultEl.querySelectorAll('.earnings, .model-potential');
                els.forEach(el => {
                    if (el && window.calculatorBgUrl) {
                        el.style.backgroundImage = `url('${window.calculatorBgUrl}')`;
                        el.style.backgroundSize = 'cover';
                        el.style.backgroundPosition = 'center center';
                        el.style.display = 'flex';
                        el.style.alignItems = 'center';
                        el.style.justifyContent = 'center';
                        el.style.color = 'white';
                        el.style.fontSize = '42px';
                        el.style.fontWeight = 'bold';
                    }
                });

                recalculateButtonContainer.style.display = 'block';
                setTimeout(() => {
                    recalculateButtonContainer.style.opacity = '1';
                }, 50);
            })
            .catch(err => {
                console.error(err);
                loadingAnim.destroy();
                loadContainer.style.display = "none";
                resultEl.innerHTML = `<p style="color:red;">Failed to fetch earnings. Please try again later.</p>`;
                resultEl.style.display = "block";
            });
    });

    recalculateButton.addEventListener('click', () => {
        current = 0;
        showStep(current);
        resultEl.style.display = 'none';
        recalculateButtonContainer.style.display = 'none';
        recalculateButtonContainer.style.opacity = '0';
        form.reset();
    });
});

function getIncomeCategory(income) {
    const n = parseFloat(income.replace(/,/g, '')) || 0;
    if (n > 100000) {
        return {
            label: "💎",
            title: "Diamond Tier",
            description:
                "You’ve cracked the code, six figures a month, VIP fanbase, and a team scaling you to the moon. You’re playing in the big leagues now but can you grow more?"
        };
    }
    if (n >= 50000) {
        return {
            label: "🥇",
            title: "Gold Tier",
            description:
                "Five figures monthly and climbing. Fans love you, sales flow in, but there’s another level waiting, ready to push for Diamond?"
        };
    }
    if (n >= 10000) {
        return {
            label: "🥈",
            title: "Silver Tier",
            description:
                "You’re making money, and it’s getting serious. A few tweaks, better strategy, and you could be hitting Gold faster than you think."
        };
    }
    return {
        label: "🥉",
        title: "Bronze Tier",
        description:
            "Just getting started, but the potential is there. Nail your content, lock in your fans, and watch the numbers climb, Silver is closer than you think."
    };
}