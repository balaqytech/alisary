import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

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
    const interval = 3;

    gsap.set(slides, { autoAlpha: 0, zIndex: 0 });
    gsap.set(slides[0], { autoAlpha: 1, zIndex: 2 });

    if (isTouchDevice) {
        slides[0].querySelector('[data-hero-media]')?.classList.add('kenburns-active');
    } else {
        gsap.fromTo(slides[0].querySelector('[data-hero-media]'), {
            scale: 1.18,
            xPercent: -1.2,
        }, {
            scale: 1.045,
            xPercent: 0,
            duration: 4.8,
            ease: 'none',
            force3D: true,
        });
    }
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

    if (! prefersReducedMotion && ! isTouchDevice) {
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

        activeIndex = nextIndex;
        setButtonState(activeIndex);
        runProgress();

        // Kill any running kenburns CSS animation on all slides
        slides.forEach((slide) => {
            slide.querySelector('[data-hero-media]')?.classList.remove('kenburns-active');
        });

        if (isTouchDevice) {
            // Use lightweight CSS animation on mobile
            void nextMedia.offsetWidth; // force reflow to restart animation
            nextMedia.classList.add('kenburns-active');
        } else {
            gsap.fromTo(nextMedia, { scale: 1.18, xPercent: -1.8 }, { scale: 1.045, xPercent: 0, duration: 4.8, ease: 'none', force3D: true });
        }

        const timeline = gsap.timeline({
            defaults: { ease: 'power3.out' },
            onComplete: () => {
                isAnimating = false;
            },
        });

        timeline
            .set(nextSlide, { zIndex: 3, autoAlpha: 1 })
            .set(nextWords, { y: 42 })
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

function initMobileNavigation() {
    const toggle = document.querySelector('[data-mobile-nav-toggle]');
    const drawer = document.querySelector('[data-mobile-nav-drawer]');
    const closeTargets = document.querySelectorAll('[data-mobile-nav-close]');

    if (! toggle || ! drawer) {
        return;
    }

    const setOpen = (isOpen) => {
        document.documentElement.classList.toggle('mobile-nav-open', isOpen);
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        drawer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    };

    toggle.addEventListener('click', () => {
        setOpen(! document.documentElement.classList.contains('mobile-nav-open'));
    });

    closeTargets.forEach((target) => {
        target.addEventListener('click', () => setOpen(false));
    });

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setOpen(false);
        }
    });
}

function initFormWizards() {
    document.querySelectorAll('[data-form-wizard]').forEach((form) => {
        const steps = [...form.querySelectorAll('[data-wizard-step]')];
        const indicators = [...form.querySelectorAll('[data-wizard-indicator]')];
        const previousButton = form.querySelector('[data-wizard-prev]');
        const nextButton = form.querySelector('[data-wizard-next]');
        const submitButton = form.querySelector('[data-wizard-submit]');
        let activeIndex = 0;

        if (steps.length === 0) {
            return;
        }

        const update = () => {
            steps.forEach((step, index) => {
                step.classList.toggle('hidden', index !== activeIndex);
            });

            indicators.forEach((indicator, index) => {
                indicator.classList.toggle('is-active', index === activeIndex);
            });

            if (previousButton) {
                previousButton.disabled = activeIndex === 0;
            }

            const isLastStep = activeIndex === steps.length - 1;

            if (nextButton) {
                nextButton.style.display = isLastStep ? 'none' : 'inline-flex';
            }

            if (submitButton) {
                submitButton.style.display = isLastStep ? 'inline-flex' : 'none';
            }
        };

        previousButton?.addEventListener('click', () => {
            activeIndex = Math.max(0, activeIndex - 1);
            update();
        });

        nextButton?.addEventListener('click', () => {
            activeIndex = Math.min(steps.length - 1, activeIndex + 1);
            update();
        });

        update();
    });
}

function initJobApplicationForm() {
    const form = document.querySelector('[data-job-application-form]');
    const submitButton = form?.querySelector('[data-job-application-submit]');

    if (! form || ! submitButton) {
        return;
    }

    let isSubmitting = submitButton.disabled;

    form.addEventListener('submit', (event) => {
        if (isSubmitting) {
            event.preventDefault();

            return;
        }

        isSubmitting = true;
        submitButton.disabled = true;
        submitButton.setAttribute('aria-disabled', 'true');
        submitButton.textContent = submitButton.dataset.submittingLabel;
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initHeader();
    initMobileNavigation();
    initHeroSlider();
    initScrollReveals();
    initFormWizards();
    initJobApplicationForm();
});
