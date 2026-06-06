import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function splitHeroWords(root) {
    root.querySelectorAll('[data-split-words]').forEach((element) => {
        const words = element.textContent.trim().split(/\s+/).filter(Boolean);

        element.innerHTML = words
            .map((word) => `<span class="hero-word"><span>${word}</span></span>`)
            .join('');
    });
}

function initHeroSlider() {
    const root = document.querySelector('[data-hero-slider]');

    if (! root) {
        return;
    }

    splitHeroWords(root);

    const slides = [...root.querySelectorAll('[data-hero-slide]')];
    const buttons = [...root.querySelectorAll('[data-hero-button]')];
    const progressBars = buttons.map((button) => button.querySelector('span'));

    if (slides.length === 0) {
        return;
    }

    let activeIndex = 0;
    let progressTween = null;
    let isAnimating = false;
    const interval = 7.6;

    gsap.set(slides, { autoAlpha: 0, zIndex: 0 });
    gsap.set(slides[0], { autoAlpha: 1, zIndex: 2 });
    gsap.fromTo(slides[0].querySelector('[data-hero-media]'), {
        scale: 1.18,
        xPercent: -1.2,
    }, {
        scale: 1.045,
        xPercent: 0,
        duration: 8.8,
        ease: 'none',
    });
    gsap.set(slides[0].querySelectorAll('[data-hero-reveal]'), { autoAlpha: 1, y: 0 });
    gsap.fromTo(slides[0].querySelectorAll('.hero-word > span'), {
        y: 42,
    }, {
        y: 0,
        duration: 1.2,
        ease: 'power4.out',
        stagger: 0.045,
        delay: 0.25,
    });

    if (! prefersReducedMotion) {
        const setMediaX = gsap.quickTo(root, '--hero-x', { duration: 0.6, ease: 'power3.out' });
        const setMediaY = gsap.quickTo(root, '--hero-y', { duration: 0.6, ease: 'power3.out' });

        root.addEventListener('pointermove', (event) => {
            const rect = root.getBoundingClientRect();
            const x = ((event.clientX - rect.left) / rect.width - 0.5) * 2;
            const y = ((event.clientY - rect.top) / rect.height - 0.5) * 2;

            setMediaX(`${x * 18}px`);
            setMediaY(`${y * 12}px`);
        });
    }

    function setButtonState(index) {
        buttons.forEach((button, buttonIndex) => {
            button.setAttribute('aria-current', buttonIndex === index ? 'true' : 'false');
        });

        gsap.set(progressBars, { scaleX: 0, transformOrigin: 'right center' });
    }

    function runProgress() {
        progressTween?.kill();

        if (prefersReducedMotion || slides.length < 2) {
            return;
        }

        progressTween = gsap.to(progressBars[activeIndex], {
            scaleX: 1,
            duration: interval,
            ease: 'none',
            onComplete: () => showSlide((activeIndex + 1) % slides.length),
        });
    }

    function showSlide(nextIndex) {
        if (nextIndex === activeIndex || isAnimating) {
            return;
        }

        isAnimating = true;
        progressTween?.kill();

        const currentSlide = slides[activeIndex];
        const nextSlide = slides[nextIndex];
        const nextMedia = nextSlide.querySelector('[data-hero-media]');
        const nextReveals = [...nextSlide.querySelectorAll('[data-hero-reveal]')]
            .filter((element) => ! element.matches('.hero-title'));
        const nextWords = nextSlide.querySelectorAll('.hero-word > span');

        slides.forEach((slide, index) => {
            slide.setAttribute('aria-hidden', index === nextIndex ? 'false' : 'true');
        });

        setButtonState(nextIndex);

        const timeline = gsap.timeline({
            defaults: { ease: 'power3.out' },
            onComplete: () => {
                activeIndex = nextIndex;
                isAnimating = false;
                runProgress();
            },
        });

        timeline
            .set(nextSlide, { zIndex: 3, autoAlpha: 1 })
            .set(nextWords, { y: 42 })
            .fromTo(nextMedia, { scale: 1.18, xPercent: -1.8 }, { scale: 1.045, xPercent: 0, duration: 8.8, ease: 'none' }, 0)
            .fromTo(nextReveals, { autoAlpha: 0, y: 36 }, { autoAlpha: 1, y: 0, duration: 1.25, stagger: 0.12 }, 0.18)
            .to(nextWords, { y: 0, duration: 1.12, ease: 'power4.out', stagger: 0.045 }, 0.18)
            .to(currentSlide, { autoAlpha: 0, duration: 1.1, ease: 'power2.out' }, 0.08)
            .set(currentSlide, { zIndex: 0 })
            .set(nextSlide, { zIndex: 2 });
    }

    buttons.forEach((button, index) => {
        button.addEventListener('click', () => showSlide(index));
    });

    setButtonState(0);
    runProgress();
}

function initScrollReveals() {
    const items = document.querySelectorAll('[data-reveal], .lux-card, .section-head');

    if (prefersReducedMotion || items.length === 0) {
        return;
    }

    items.forEach((item) => {
        gsap.fromTo(item, {
            autoAlpha: 0,
            y: 32,
        }, {
            autoAlpha: 1,
            y: 0,
            duration: 1,
            ease: 'power3.out',
            scrollTrigger: {
                trigger: item,
                start: 'top 86%',
                once: true,
            },
        });
    });
}

function initHeader() {
    const header = document.querySelector('[data-site-header]');

    if (! header) {
        return;
    }

    const updateHeader = () => {
        header.classList.toggle('is-scrolled', window.scrollY > 24);
    };

    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });
}

document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initHeroSlider();
    initScrollReveals();
});
