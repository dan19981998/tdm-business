document.addEventListener('DOMContentLoaded', function(){
    const blocks   = document.querySelector('.how-we-help .blocks');
    const indicator = document.querySelector('.how-we-help .scroll-indicator');
    if (!blocks || !indicator) return;

    function updateIndicator(){
      const maxScroll = blocks.scrollWidth - blocks.clientWidth;
      const pct       = maxScroll > 0 ? (blocks.scrollLeft / maxScroll) : 0;
      
      let calculatedWidth = Math.round(pct * 100);

      if (calculatedWidth === 0 && maxScroll > 0) { 
        indicator.style.width = '10px'; 
      } else {
        indicator.style.width = calculatedWidth + '%';
      }
    }

    blocks.addEventListener('scroll', updateIndicator, { passive: true }); 
    window.addEventListener('resize', updateIndicator);
    updateIndicator();
});