document.addEventListener("DOMContentLoaded", function() {
  // ----------------------------
  // Tab‐navigation logic (unchanged)
  // ----------------------------
  const tabs = document.querySelectorAll(".tab-nav-item");
  const contents = document.querySelectorAll(".tab-content");

  tabs.forEach(tab => {
    tab.addEventListener("click", function() {
      const targetId = this.getAttribute("data-tab");

      tabs.forEach(t => t.classList.remove("active"));
      contents.forEach(c => c.classList.remove("active"));

      this.classList.add("active");
      const panel = document.getElementById(targetId);
      if (panel) {
        panel.classList.add("active");
      }
    });
  });

  
  const accordionItems = document.querySelectorAll(".team-accordion__item");
  const cardGroups     = document.querySelectorAll(".team-cards[data-group]");

  accordionItems.forEach(item => {
    const btn = item.querySelector(".team-accordion__button");
    btn.addEventListener("click", function() {
      accordionItems.forEach(i => {
        i.classList.remove("team-accordion__item--active");
        const caret = i.querySelector(".team-accordion__caret");
        if (caret) caret.innerHTML = "&#9660;"; // ▼
      });

      item.classList.add("team-accordion__item--active");
      const thisCaret = item.querySelector(".team-accordion__caret");
      if (thisCaret) thisCaret.innerHTML = "&#9650;"; // ▲

      const clickedIndex = item.getAttribute("data-index");

      cardGroups.forEach(group => {
        if (group.getAttribute("data-group") === clickedIndex) {
          group.style.display = "";
        } else {
          group.style.display = "none";
        }
      });

      if (window.innerWidth <= 1000) {
        document
          .querySelectorAll(".team-accordion__panel .team-cards")
          .forEach(el => el.remove());

        const originalGroup = document.querySelector(
          `.team-cards[data-group="${clickedIndex}"]`
        );
        if (originalGroup) {
          const clonedGroup = originalGroup.cloneNode(true);
          clonedGroup.style.display = "grid";
          const panel = item.querySelector(".team-accordion__panel");
          if (panel) {
            panel.appendChild(clonedGroup);
          }
        }
      }
    });
  });

  
  function cloneActiveAccordionOnLoad() {
    if (window.innerWidth > 1000) return; 

    const preActive = document.querySelector(
      ".team-accordion__item.team-accordion__item--active"
    );
    if (!preActive) return;

    const idx = preActive.getAttribute("data-index");
    if (!idx) return;

    document
      .querySelectorAll(".team-accordion__panel .team-cards")
      .forEach(el => el.remove());

    const originalGroup = document.querySelector(
      `.team-cards[data-group="${idx}"]`
    );
    if (!originalGroup) return;

    const clonedGroup = originalGroup.cloneNode(true);
    clonedGroup.style.display = "grid";

    const panel = preActive.querySelector(".team-accordion__panel");
    if (panel) {
      panel.appendChild(clonedGroup);
    }
  }

  cloneActiveAccordionOnLoad();

 
  window.addEventListener("resize", () => {
    document
      .querySelectorAll(".team-accordion__panel .team-cards")
      .forEach(el => el.remove());

    if (window.innerWidth <= 1000) {
      cloneActiveAccordionOnLoad();
    } else {
      cardGroups.forEach(g => {
        g.style.display = "";
      });
    }
  });
});

