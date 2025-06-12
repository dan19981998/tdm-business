<?php
$bg = get_field('calculator_bg');
$bg_url = $bg ? esc_url($bg['url']) : ''; ?>

<section class="calculator" <?php if ($bg_url) : ?>style="background-image: url('<?php echo $bg_url; ?>'); background-size: cover; background-position: center;"<?php endif; ?>>
    <form id="earningsForm">
        <h2 class="calculator-title"> <?php the_field("calculator_title") ?> </h2>
        <p class="calculator-subheading"><?php the_field("calculator_subheading") ?></p>
        <div class="step-indicator">
            <div class="step-wrapper">
                <span class="step-num active">1</span>
                <hr class="step-sep" />
                <span class="step-num">2</span>
                <hr class="step-sep" />
                <span class="step-num">3</span>
            </div>
            <div id="recalculateButtonContainer" class="animate-border" style="text-align: center; margin-top: 13px; opacity: 0; transition: opacity 1s ease-in-out; display: none;">
                <button type="button" id="recalculateButton" class="cta">Consultation</button>
            </div>
        </div>
        <fieldset class="step" data-step="1">
            <div class="flex-box">
                <div class="form-row">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" required>
                </div>
                <div class="form-row">
                    <label for="following">Instagram Handle</label>
                    <input type="text" id="following" name="following" required>
                </div>
            </div>
            <div class="form-row">
                <label for="branding">Branding</label>
                <select id="branding" name="branding">
                    <option value="occupational-niche">Occupational Niche (e.g., nurse, trainer, doctor)</option>
                    <option value="gym-girl">Gym Girl</option>
                    <option value="gamer">Gamer</option>
                    <option value="e-girl">E-Girl</option>
                    <option value="goth">Goth</option>
                    <option value="trans">Trans</option>
                    <option value="femboy">Femboy</option>
                    <option value="sports">Sports (Football, Golf, etc.)</option>
                    <option value="girl-next-door">Girl Next Door</option>
                    <option value="femdom">FemDom</option>
                    <option value="worship">Worship</option>
                    <option value="bbw">BBW</option>
                    <option value="milf">MILF</option>
                    <option value="teen">Teen</option>
                    <option value="pregnant">Pregnant</option>
                </select>
            </div>
            <div class="flex-box">
                <div class="form-row">
                    <label for="location">Location</label>
                    <select id="location" name="location">
                        <option value="NA">North America</option>
                        <option value="WE">West Europe</option>
                        <option value="EE">East Europe</option>
                        <option value="SA">South America</option>
                        <option value="AS">Asia</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-row">
                    <label for="management">Do you have management?</label>
                    <select id="management" name="management">
                        <option value="Yes full service">Yes full service</option>
                        <option value="Yes, chatting only">Yes chatting only</option>
                        <option value="No">No</option>
                        <option value="I'm new to OnlyFans">I'm new to OnlyFans</option>
                    </select>
                </div>
            </div>
            <div class="animate-border">
                <button type="button" class="next cta">Proceed To Next Step</button>
            </div>
        </fieldset>

        <fieldset class="step" data-step="2" style="display:none">
            <div class="form-row">
                <label>Traffic Options:</label>
                <div class="radio-group">
                    <div class="traffic-option-1">
                        <div class="option-value">
                            <input type="radio" id="trafficTier1" name="traffic" value="tier1" checked>
                            <label for="trafficTier1" class="no-margin">Traffic Tier 1</label>
                            <div class="explanantion">This is if most of your traffic comes from video/streaming services i.e. Twitch, Youtube etc.</div>
                        </div>
                        <div class="logos">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/tierA.webp'); ?>" alt="twitch/youtube logos" style="width:100%; height:auto;" />
                        </div>
                    </div>
                    <div class="traffic-option-2">
                        <div class="option-value">
                            <input type="radio" id="trafficTier2" name="traffic" value="tier2">
                            <label for="trafficTier2" class="no-margin">Traffic Tier 2</label>
                            <div class="explanantion2">This is if most of your traffic comes from social media i.e. Instagram, Twitter, Reddit etc.</div>
                        </div>
                        <div class="logos">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/tierB.webp'); ?>" alt="instagram and tier 2 logos" style="width:100%; height:auto;" />
                        </div>
                    </div>
                    <div class="traffic-option-3">
                        <div class="option-value">
                            <input type="radio" id="trafficTier3" name="traffic" value="tier3">
                            <label for="trafficTier3" class="no-margin">Traffic Tier 3
                            </label>
                            <div class="explanantion3">This is if most of your traffic comes from other adult platforms i.e. Porn Websites etc.</div>

                        </div>
                        <div class="logos">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/tierC.webp'); ?>" alt="instagram and tier 2 logos" style="width:100%; height:auto;" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="look-div">
                    <label for="looksSlider">Rate Your Looks:</label>
                    <p id="looksMessage"></p>
                </div>
                <input type="range" id="looksSlider" min="1" max="10" value="5">
                <input type="hidden" id="looks" name="looks" value="5">
            </div>
            <div class="form-row">
                <div class="look-div">
                    <label for="workEthicSlider">What is your work ethic?</label>
                    <p id="workEthicMessage"></p>
                </div>
                <input type="range" id="workEthicSlider" min="1" max="10" value="5">
                <input type="hidden" id="workEthic" name="workEthic" value="5">
            </div>
            <div class="flex-box">
                <div class="form-row">
                    <label>Custom requests?</label>
                    <div class="radio-button">
                        <label><input type="radio" name="custom" value="yes"> Yes</label>
                        <label><input type="radio" name="custom" value="no" checked> No</label>
                    </div>
                </div>
                <div class="form-row">
                    <label>Explicit content?</label>
                    <div class="radio-button">
                        <label><input type="radio" name="explicit" value="yes"> Yes</label>
                        <label><input type="radio" name="explicit" value="no" checked> No</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <label>Do you speak English?</label>
                <div class="radio-button">
                    <label><input type="radio" name="speaksEnglish" value="yes" checked> Yes</label>
                    <label><input type="radio" name="speaksEnglish" value="no"> No</label>
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="prev cta" style="width: 30%; color:black;">Back</button>
                <div class="animate-border" style="width: 70%; margin-bottom:0;">
                    <button type="button" class="next cta">Calculate</button>
                </div>
            </div>
        </fieldset>

        <fieldset class="step" data-step="3" style="display:none">
            <div id="loadingContainer" style="display:none; text-align:center; width: 300px; margin:auto"></div>
            <div id="result" class="show-section"></div>
        </fieldset>
    </form>
</section>

<script>
    window.calculatorBgUrl = "<?php echo $bg_url; ?>";
</script>