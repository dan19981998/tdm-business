document.addEventListener('DOMContentLoaded', function() {
  var scrollLottieContainer = document.querySelector('.lottie-scroll');
  var swipeLottieContainer = document.querySelector('.lottie-swipe');
  var tickLottieContainers = document.querySelectorAll('.lottie-tick');
  var chattingServicesSection = document.querySelector('.chatting-services-section');

  var animLib = window.lottie || window.bodymovin;
  var tickAnimations = [];

  if (animLib) {
    if (scrollLottieContainer) {
      animLib.loadAnimation({
        container: scrollLottieContainer,
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: tdm_paths.lottiePath + 'scroll.json'
      });
    }
    if (swipeLottieContainer) {
      animLib.loadAnimation({
        container: swipeLottieContainer,
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: tdm_paths.lottiePath + 'swipe.json'
      });
    }

    if (tickLottieContainers.length > 0) {
      tickLottieContainers.forEach(function(container) {
        const anim = animLib.loadAnimation({
          container: container,
          renderer: 'svg',
          loop: false,
          autoplay: false,
          path: tdm_paths.lottiePath + 'tick.json'
        });
        tickAnimations.push(anim);
      });
    }

    if (chattingServicesSection && tickAnimations.length > 0) {
      let options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5
      };

      let observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            tickAnimations.forEach(anim => {
              if (anim && typeof anim.play === 'function') {
                  anim.play();
              }
            });
            observer.unobserve(entry.target);
          }
        });
      }, options);

      observer.observe(chattingServicesSection);
    }
  }

  const blocks = document.querySelector('.how-we-help .blocks');
  let hasUserInteractedWithSlider = false;

  if (blocks) {
    blocks.addEventListener('scroll', function() {
      if (blocks.scrollLeft > 0 && !hasUserInteractedWithSlider) {
        hasUserInteractedWithSlider = true;
        if (swipeLottieContainer) {
          swipeLottieContainer.classList.add('fade-out-lottie');
        }
      }
    }, { passive: true });
  }
});