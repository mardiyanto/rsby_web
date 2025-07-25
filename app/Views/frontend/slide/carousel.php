<?php
// Ambil slide aktif dari database
$slideModel = new \App\Models\SlideModel();
$slides = $slideModel->getActiveSlides();
?>

<?php if (!empty($slides)): ?>
<div id="slideCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
  <!-- Indicators/dots -->
  <div class="carousel-indicators">
    <?php foreach ($slides as $index => $slide): ?>
    <button type="button" data-bs-target="#slideCarousel" data-bs-slide-to="<?= $index ?>" 
            class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
            aria-label="Slide <?= $index + 1 ?>"></button>
    <?php endforeach; ?>
  </div>

  <!-- The slideshow/carousel -->
  <div class="carousel-inner">
    <?php foreach ($slides as $index => $slide): ?>
    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
      <?php if ($slide['link']): ?>
        <a href="<?= esc($slide['link']) ?>" target="_blank">
      <?php endif; ?>
      
      <img src="<?= base_url('uploads/slide/'.$slide['gambar']) ?>" 
           class="d-block w-100" 
           alt="<?= esc($slide['judul']) ?>"
           style="height: 400px; object-fit: cover;">
      
      <div class="carousel-caption d-none d-md-block">
        <h3><?= esc($slide['judul']) ?></h3>
        <p><?= esc($slide['deskripsi']) ?></p>
        <?php if ($slide['link']): ?>
          <a href="<?= esc($slide['link']) ?>" class="btn btn-primary btn-sm" target="_blank">
            <i class="fas fa-external-link-alt"></i> Selengkapnya
          </a>
        <?php endif; ?>
      </div>
      
      <?php if ($slide['link']): ?>
        </a>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Left and right controls/icons -->
  <button class="carousel-control-prev" type="button" data-bs-target="#slideCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#slideCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- Mobile caption -->
<div class="d-md-none mt-3">
  <?php foreach ($slides as $index => $slide): ?>
  <div class="slide-caption-mobile <?= $index === 0 ? 'active' : '' ?>" data-slide="<?= $index ?>">
    <h5><?= esc($slide['judul']) ?></h5>
    <p class="text-muted"><?= esc($slide['deskripsi']) ?></p>
    <?php if ($slide['link']): ?>
      <a href="<?= esc($slide['link']) ?>" class="btn btn-primary btn-sm" target="_blank">
        <i class="fas fa-external-link-alt"></i> Selengkapnya
      </a>
    <?php endif; ?>
  </div>
  <?php endforeach; ?>
</div>

<style>
.carousel-item {
  position: relative;
}

.carousel-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.6));
  z-index: 1;
}

.carousel-caption {
  z-index: 2;
  bottom: 20%;
}

.carousel-caption h3 {
  font-size: 2.5rem;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
  margin-bottom: 1rem;
}

.carousel-caption p {
  font-size: 1.1rem;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
  margin-bottom: 1.5rem;
}

.carousel-indicators {
  bottom: 30px;
}

.carousel-indicators button {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  margin: 0 5px;
}

.carousel-control-prev,
.carousel-control-next {
  width: 5%;
}

.slide-caption-mobile {
  display: none;
  padding: 15px;
  background: #f8f9fa;
  border-radius: 8px;
  margin-bottom: 15px;
}

.slide-caption-mobile.active {
  display: block;
}

@media (max-width: 768px) {
  .carousel-caption {
    display: none !important;
  }
  
  .carousel-item img {
    height: 250px !important;
  }
}

@media (max-width: 576px) {
  .carousel-item img {
    height: 200px !important;
  }
  
  .carousel-caption h3 {
    font-size: 1.5rem;
  }
  
  .carousel-caption p {
    font-size: 0.9rem;
  }
}
</style>

<script>
// Update mobile caption when slide changes
document.addEventListener('DOMContentLoaded', function() {
  const carousel = document.getElementById('slideCarousel');
  const mobileCaptions = document.querySelectorAll('.slide-caption-mobile');
  
  carousel.addEventListener('slid.bs.carousel', function(event) {
    // Hide all mobile captions
    mobileCaptions.forEach(caption => {
      caption.classList.remove('active');
    });
    
    // Show active mobile caption
    const activeIndex = event.to;
    const activeCaption = document.querySelector(`.slide-caption-mobile[data-slide="${activeIndex}"]`);
    if (activeCaption) {
      activeCaption.classList.add('active');
    }
  });
});
</script>

<?php else: ?>
<!-- Fallback jika tidak ada slide -->
<div class="alert alert-info text-center py-5">
  <i class="fas fa-info-circle fa-3x mb-3"></i>
  <h4>Tidak ada slide yang aktif</h4>
  <p class="mb-0">Silakan hubungi administrator untuk mengaktifkan slide.</p>
</div>
<?php endif; ?> 