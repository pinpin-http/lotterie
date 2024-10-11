import * as THREE from 'three';

// Initialisation de la scène, de la caméra et du renderer
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer({ alpha: true });
renderer.setSize(window.innerWidth, window.innerHeight);
document.body.appendChild(renderer.domElement);
renderer.domElement.id = 'backgroundCanvas'; // Ajout d'un ID au canevas
// Position de la caméra
camera.position.z = 0;

// Chemins des images de boules de loterie


const lotteryBallImages = [
    './frontoffice/img/boules/boule1.png',  // Remplacez par le chemin de vos images
    './frontoffice/img/boules/boule2.png',
    './frontoffice/img/boules/boule3.png',
    './frontoffice/img/boules/boule4.png',
    './frontoffice/img/boules/boule5.png',
    './frontoffice/img/boules/boule6.png',
    './frontoffice/img/boules/boule7.png',
    './frontoffice/img/boules/boule8.png',


];
// Fonction pour créer un sprite de boule de loterie avec une image
function createLotteryBall() {
    // Charge une image aléatoire pour la boule
    const textureLoader = new THREE.TextureLoader();
    const texture = textureLoader.load(
        lotteryBallImages[Math.floor(Math.random() * lotteryBallImages.length)]
    );

    // Créer un sprite pour afficher la texture de la boule
    const material = new THREE.SpriteMaterial({ map: texture, transparent: true });
    const sprite = new THREE.Sprite(material);

    // Taille aléatoire pour chaque boule
    const size = 5 + Math.random() * 2; // Taille entre 5 et 7
    sprite.scale.set(size, size, 1);

    // Position initiale aléatoire
    sprite.position.set(
        (Math.random() - 0.5) * 80,
        (Math.random() - 0.5) * 80,
        (Math.random() - 0.5) * 80
    );

    scene.add(sprite);
    return sprite;
}

// Génération des sprites de boules
const balls = Array.from({ length: 20 }, createLotteryBall);

// Animation pour faire légèrement flotter les boules
function animate() {
    requestAnimationFrame(animate);

    // Déplacement léger et fluide de chaque boule
 // Déplacement plus marqué et fluide de chaque boule
balls.forEach((ball) => {
    ball.position.x += Math.sin(Date.now() * 0.002 + ball.position.x) * 0.03; // Augmenter l'amplitude et la vitesse
    ball.position.y += Math.cos(Date.now() * 0.002 + ball.position.y) * 0.03;
     // Limiter le déplacement des boules pour les maintenir dans les limites de l'écran
     const limit = 50; // Ajustez la limite en fonction de la taille de votre scène
     if (ball.position.x > limit || ball.position.x < -limit) {
         ball.position.x = Math.random() * 40 - 20; // Repositionner la boule près du centre
     }
     if (ball.position.y > limit || ball.position.y < -limit) {
         ball.position.y = Math.random() * 40 - 20;
     }
});

    renderer.render(scene, camera);
}

animate();

// Adapter le renderer à la taille de l'écran
window.addEventListener('resize', () => {
    renderer.setSize(window.innerWidth, window.innerHeight);
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
});

