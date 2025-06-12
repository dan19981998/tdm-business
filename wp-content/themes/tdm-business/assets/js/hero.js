import * as THREE from 'https://unpkg.com/three@0.153.0/build/three.module.js?module';


const canvas = document.getElementById('hero-canvas');
const renderer = new THREE.WebGLRenderer({ canvas, antialias: true });
renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(canvas.clientWidth, canvas.clientHeight);
const scene = new THREE.Scene();
const camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);
const geometry = new THREE.PlaneGeometry(2, 2);

const noiseFunc = `
  float hash(vec2 p) { return fract(sin(dot(p, vec2(127.1,311.7))) * 43758.5453123); }
  float noise(in vec2 p) {
    vec2 i = floor(p), f = fract(p);
    vec2 u = f*f*(3.0-2.0*f);
    return mix(mix(hash(i), hash(i+vec2(1,0)), u.x), mix(hash(i+vec2(0,1)), hash(i+vec2(1,1)), u.x), u.y);
  }
  float fbm(vec2 p) {
    float v = 0.0, amp = 0.3;
    for(int i=0; i<5; i++) { v += amp * noise(p); p *= 2.0; amp *= 0.5; }
    return v;
  }
`;

const material = new THREE.ShaderMaterial({
  uniforms: {
    u_time:       { value: 0 },
    u_resolution: { value: new THREE.Vector2(canvas.clientWidth, canvas.clientHeight) },
    u_brightness: { value: 1.0 }   // 70% brightness
  },
  vertexShader: `
    varying vec2 vUv;
    void main() {
      vUv = uv;
      gl_Position = vec4(position, 1.0);
    }
  `,
  fragmentShader: `
    uniform float u_time;
    uniform vec2 u_resolution;
    uniform float u_brightness;
    varying vec2 vUv;
    ${noiseFunc}

    void main() {
      vec2 uv = vUv;
      vec2 uvTL = vec2(uv.x, 1.0 - uv.y);

      float base = exp(-dot(uvTL, uvTL) * 2.0);
      float noiseVal = fbm(uvTL * 1.0 + u_time * 0.015);
      float strength = clamp(base * (1.0 + 0.2 * (noiseVal - 0.5)), 0.0, 1.0);

      vec3 c0 = vec3(0.00, 0.64, 0.84) * 0.8;  
      vec3 c1 = vec3(0.82, 0.34, 0.70) * 0.8;  
      vec3 c2 = vec3(0.07, 0.69, 0.47) * 0.8; 
      vec3 c3 = vec3(0.63, 0.53, 0.44) * 0.8;  

      float cycle = mod(u_time * 0.05, 1.0);
      float idx   = cycle * 4.0;
      int seg     = int(floor(idx));
      float lt    = fract(idx);
      vec3 color = seg == 0 ? mix(c0, c1, lt)
                 : seg == 1 ? mix(c1, c2, lt)
                 : seg == 2 ? mix(c2, c3, lt)
                            : mix(c3, c0, lt);

      // apply brightness uniform
      vec3 finalCol = color * strength * u_brightness;
      gl_FragColor = vec4(finalCol, 1.0);
    }
  `
});


const mesh = new THREE.Mesh(geometry, material);
scene.add(mesh);

function onResize() {
  const { clientWidth: w, clientHeight: h } = canvas;
  renderer.setSize(w, h);
  material.uniforms.u_resolution.value.set(w, h);
}
window.addEventListener('resize', onResize);
onResize();

const clock = new THREE.Clock();
function animate() {
  material.uniforms.u_time.value = clock.getElapsedTime();
  renderer.render(scene, camera);
  requestAnimationFrame(animate);
}
animate();


document.addEventListener('DOMContentLoaded', function(){
  const track = document.querySelector('.hero-slider .slider-track');
  const slides = Array.from(track.children);
  const step = 1;
  let index; // will be set after getting visible count

  function getVisibleCount() {
    return window.innerWidth <= 900 ? 1 : 3;
  }

  function getTrackOffset(idx) {
    let offset = 0;
    for (let i = 0; i < idx; i++) {
      offset += slides[i].offsetWidth;
    }
    return offset;
  }

  function setActiveSlide() {
    slides.forEach(slide => slide.classList.remove('active'));
    const centerIndex = index + Math.floor(getVisibleCount() / 2);
    if (slides[centerIndex]) {
      slides[centerIndex].classList.add('active');
    }
  }

  function correctIndexAfterResize() {
    const visible = getVisibleCount();
    if (typeof index === 'undefined' || index < visible) {
      index = visible;
    }
    setActiveSlide();
    track.style.transition = 'none';
    track.style.transform = `translateX(${-getTrackOffset(index)}px)`;
  }

  correctIndexAfterResize();

  function move(by = step) {
    index += by;
    setActiveSlide();
    track.classList.remove('resetting');
    slides.forEach(slide => slide.classList.remove('resetting'));
    track.style.transition = 'transform 0.5s ease';
    track.style.transform = `translateX(${-getTrackOffset(index)}px)`;
  }

  track.addEventListener('transitionend', () => {
    const totalSlides = slides.length;
    const visible = getVisibleCount();
    const realSlides = totalSlides - visible * 2;
    let needsReset = false;
    let resetTo = index;

    if (index >= realSlides + visible) {
      index = visible;
      resetTo = index;
      needsReset = true;
    } else if (index < visible) {
      index = realSlides + (index % realSlides);
      resetTo = index;
      needsReset = true;
    }

    setActiveSlide();

    if (needsReset) {
      track.classList.add('resetting');
      slides.forEach(slide => slide.classList.add('resetting'));
      requestAnimationFrame(() => {
        void track.offsetWidth; // force reflow
        track.style.transition = 'none';
        track.style.transform = `translateX(${-getTrackOffset(resetTo)}px)`;

        requestAnimationFrame(() => {
          track.classList.remove('resetting');
          slides.forEach(slide => slide.classList.remove('resetting'));
          track.style.transition = 'transform 0.5s ease';
        });
      });
    }
  });

  document.querySelector('.hero-slider .prev').addEventListener('click', () => move(-step));
  document.querySelector('.hero-slider .next').addEventListener('click', () => move(step));

  window.addEventListener('resize', correctIndexAfterResize);
});

const words = ['AGENCY', 'CREATOR', 'ONLYFANS'];
const colors = ['orange', 'rgb(255, 116, 209)', 'rgb(0, 175, 240)'];
const el = document.querySelector('#typewriter-word .typewriter-inner');
const cursor = document.getElementById('typewriter-cursor');
let wordIndex = 0;

function setWordColor() {
  el.style.color = colors[wordIndex];
}

function typeWord(word, i = 0) {
  cursor.classList.remove('no-blink'); // Ensure cursor blinks when typing
  setWordColor();
  el.classList.remove('highlight');
  if (i <= word.length) {
    el.textContent = word.slice(word.length - i, word.length);
    setTimeout(() => typeWord(word, i + 1), 80);
  } else {
    setTimeout(() => {
      cursor.classList.add('no-blink'); // Cursor solid during highlight/remove
      el.classList.add('highlight');
      setTimeout(() => {
        el.textContent = '';
        el.classList.remove('highlight');
        wordIndex = (wordIndex + 1) % words.length;
        setTimeout(() => typeWord(words[wordIndex]), 500);
      }, 700); // highlight visible time
    }, 1400); // how long to show full word BEFORE highlight
  }
}

typeWord(words[wordIndex]);