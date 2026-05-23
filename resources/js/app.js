import './bootstrap';
import Alpine from 'alpinejs';
import { gsap } from "gsap";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {

    gsap.defaults({
        ease: "power3.out",
        duration: 0.8
    });

    // =========================
    // PAGE FADE
    // =========================

    gsap.from("body", {
        opacity: 0,
        duration: 0.5
    });

    // =========================
    // HERO SECTION
    // =========================

    animateIfExists(".hero-animate", {
        y: 40,
        opacity: 0,
        duration: 1
    });

    // =========================
    // CARDS
    // =========================

    animateIfExists(".card-animate", {
        y: 35,
        opacity: 0,
        stagger: 0.08,
        duration: 0.8
    });

    // =========================
    // TABLES
    // =========================

    animateIfExists(".table-animate", {
        y: 25,
        opacity: 0,
        delay: 0.1
    });

    // =========================
    // FORM ELEMENTS
    // =========================

    animateIfExists(".input-animate", {
        y: 15,
        opacity: 0,
        stagger: 0.05,
        delay: 0.15
    });

    // =========================
    // BUTTONS
    // =========================

    animateIfExists(".button-animate", {
        scale: 0.9,
        opacity: 0,
        stagger: 0.05,
        delay: 0.2
    });

    // =========================
    // SIDEBAR / NAVBAR
    // =========================

    animateIfExists(".nav-animate", {
        x: -30,
        opacity: 0,
        stagger: 0.05
    });

    // =========================
    // FLOATING EFFECT
    // =========================

    gsap.to(".floating-animation", {
        y: -12,
        duration: 2,
        repeat: -1,
        yoyo: true,
        ease: "sine.inOut"
    });

    // =========================
    // MAGNETIC HOVER
    // =========================

    document.querySelectorAll(".magnetic-hover").forEach((element) => {

        element.addEventListener("mousemove", (e) => {

            const rect = element.getBoundingClientRect();

            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;

            gsap.to(element, {
                x: x * 0.15,
                y: y * 0.15,
                duration: 0.3
            });
        });

        element.addEventListener("mouseleave", () => {

            gsap.to(element, {
                x: 0,
                y: 0,
                duration: 0.4
            });
        });
    });

    // =========================
    // PREMIUM HOVER CARD
    // =========================

    document.querySelectorAll(".premium-card").forEach((card) => {

        card.addEventListener("mouseenter", () => {

            gsap.to(card, {
                y: -10,
                scale: 1.02,
                duration: 0.3
            });
        });

        card.addEventListener("mouseleave", () => {

            gsap.to(card, {
                y: 0,
                scale: 1,
                duration: 0.3
            });
        });
    });

    // =========================
    // GLOW EFFECT
    // =========================

    document.querySelectorAll(".glow-hover").forEach((element) => {

        element.addEventListener("mouseenter", () => {

            gsap.to(element, {
                boxShadow: "0 0 40px rgba(59,130,246,0.35)",
                duration: 0.3
            });
        });

        element.addEventListener("mouseleave", () => {

            gsap.to(element, {
                boxShadow: "0 0 0 rgba(59,130,246,0)",
                duration: 0.3
            });
        });
    });

});

// =========================
// REUSABLE FUNCTION
// =========================

function animateIfExists(selector, options) {

    const elements = document.querySelectorAll(selector);

    if (elements.length > 0) {

        gsap.set(selector, {
            opacity: 1
        });

        gsap.from(selector, options);
    }
}