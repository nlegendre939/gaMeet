let toggle = document.querySelector('.toggle');
let body = document.querySelector('body');

toggle.addEventListener('click', function() {
    body.classList.toggle('open');
})

// const titre = document.querySelectorAll('h1');
// const btns = document.querySelectorAll('.btn-first');
// const logo = document.querySelector('.logo');
// const medias = document.querySelectorAll('.bulle');
// const l1 = document.querySelector('.l1');
// const l2 = document.querySelector('.l2');

// window.addEventListener('load', () => {

//     const TL = gsap.timeline({paused: true});
//     TL
//     .staggerFrom(titreSpans, 1, {top: -50, opacity: 0, ease: "power2.out"}, 0.3)
//     .staggerFrom(btns, 1, {opacity: 0, ease: "power2.out"}, 0.3, '-=1')
//     .from(l1, 1, {width: 0, ease: "power2.out"}, '-=2')
//     .from(l2, 1, {width: 0, ease: "power2.out"}, '-=2')
//     .from(logo, 0.4, {transform: "scale(0)", ease: "power2.out"}, '-=2')
//     .staggerFrom(medias, 1, {right: -200, ease: "power2.out"}, 0.3, '-=1');

//     TL.play();
// })

const notifications = document.querySelectorAll('.notification-manager .notification');

setTimeout(() => {
    for(const notification of notifications){
        notification.style.opacity = 0;
        setTimeout(() => {
            notification.remove();
        }, 500);
    }
}, 5000);

for(const notification of notifications){
    notification.querySelector('.notification-close').addEventListener('click', () => {
        notification.remove();
    });
}

const eye = document.querySelector(".feather-eye");
const eyeoff = document.querySelector(".feather-eye-off");
const passwordField = document.querySelector("input[type=password]");

eye.addEventListener("click", () => {
    eye.style.display = "none";
    eyeoff.style.display = "block";
    passwordField.type = "text";
});

eyeoff.addEventListener("click", () => {
    eyeoff.style.display = "none";
    eye.style.display = "block";
    passwordField.type = "password";
});