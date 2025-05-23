document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector(".carousel-track");
  const prevBtn = document.querySelector(".prev-btn");
  const nextBtn = document.querySelector(".next-btn");
  const cards = document.querySelectorAll(".product-card");
  const cardWidth = cards[0].offsetWidth + 20; // Width + gap
  const visibleCards = 3; // Number of cards visible at once
  const maxPosition = -cardWidth * (cards.length - visibleCards);
  let currentPosition = 0;
  // Update button states based on current position
  function updateButtons() {
    prevBtn.disabled = currentPosition === 0;
    nextBtn.disabled = currentPosition <= maxPosition;
    // Visual feedback for disabled state
    prevBtn.style.opacity = currentPosition === 0 ? "0.5" : "1";
    nextBtn.style.opacity = currentPosition <= maxPosition ? "0.5" : "1";
  }

  // Next Button
  nextBtn.addEventListener("click", () => {
    if (currentPosition > maxPosition) {
      currentPosition -= cardWidth;
      // Don't go past the last item
      if (currentPosition < maxPosition) currentPosition = maxPosition;
      track.style.transition = "transform 0.5s ease";
      track.style.transform = `translateX(${currentPosition}px)`;
      updateButtons();
    }
  });
  // Previous Button
  prevBtn.addEventListener("click", () => {
    if (currentPosition < 0) {
      currentPosition += cardWidth;
      // Don't go past the first item
      if (currentPosition > 0) currentPosition = 0;
      track.style.transition = "transform 0.5s ease";
      track.style.transform = `translateX(${currentPosition}px)`;
      updateButtons();
    }
  });
  // Touch/Swipe Support (for mobile)
  let touchStartX = 0;
  track.addEventListener("touchstart", (e) => {
    touchStartX = e.touches[0].clientX;
    track.style.transition = "none"; // Disable transition during swipe
  });
  track.addEventListener("touchend", (e) => {
    const touchEndX = e.changedTouches[0].clientX;
    track.style.transition = "transform 0.5s ease"; // Re-enable transition
    if (touchStartX - touchEndX > 50 && currentPosition > maxPosition) {
      nextBtn.click(); // Swipe left
    } else if (touchEndX - touchStartX > 50 && currentPosition < 0) {
      prevBtn.click(); // Swipe right
    }
  });
  updateButtons();
});
