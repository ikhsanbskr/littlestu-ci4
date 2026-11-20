/* =========================================================
   LITTLESTU — public/js/script.js (Connected to CI4 API)
   ========================================================= */
(function () {
  "use strict";

  const CFG = window.LITTLESTU_CONFIG || {
    baseUrl: "/",
    whatsappNumber: "6281288107710",
    shopeeUrl: "https://id.shp.ee/84ng9Z7B",
    tiktokUrl: "https://www.tiktok.com/@littlestu.kidswear",
    fallbackImg: "/images/placeholder.svg",
  };

  function buildWaUrl(text) {
    return `https://wa.me/${CFG.whatsappNumber}?text=${encodeURIComponent(text)}`;
  }

  function trackEvent(eventType, slug = "", meta = "") {
    try {
      fetch(`${CFG.baseUrl}api/track`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ event_type: eventType, slug, meta }),
        keepalive: true,
      }).catch(() => {});
    } catch (_) {}
  }

  // Header scroll & back to top
  const header = document.getElementById("siteHeader");
  const backToTop = document.getElementById("backToTop");
  function onScroll() {
    const scrolled = window.scrollY > 8;
    header?.classList.toggle("is-scrolled", scrolled);
    if (backToTop) {
      backToTop.hidden = window.scrollY < 500;
      backToTop.classList.toggle("is-visible", window.scrollY >= 500);
    }
  }
  window.addEventListener("scroll", onScroll, { passive: true });
  onScroll();
  backToTop?.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));

  // Mobile drawer
  const menuToggle = document.getElementById("menuToggle");
  const drawer = document.getElementById("mobileDrawer");
  const drawerBackdrop = document.getElementById("drawerBackdrop");
  const drawerClose = document.getElementById("drawerClose");
  function openDrawer() {
    drawer.classList.add("is-open");
    drawer.setAttribute("aria-hidden", "false");
    drawerBackdrop.hidden = false;
    requestAnimationFrame(() => drawerBackdrop.classList.add("is-visible"));
    menuToggle.setAttribute("aria-expanded", "true");
    document.body.style.overflow = "hidden";
    drawerClose.focus();
  }
  function closeDrawer() {
    drawer.classList.remove("is-open");
    drawer.setAttribute("aria-hidden", "true");
    drawerBackdrop.classList.remove("is-visible");
    menuToggle.setAttribute("aria-expanded", "false");
    document.body.style.overflow = "";
    setTimeout(() => { drawerBackdrop.hidden = true; }, 250);
    menuToggle.focus();
  }
  menuToggle?.addEventListener("click", () => (drawer.classList.contains("is-open") ? closeDrawer() : openDrawer()));
  drawerClose?.addEventListener("click", closeDrawer);
  drawerBackdrop?.addEventListener("click", closeDrawer);
  drawer?.querySelectorAll("a").forEach((a) => a.addEventListener("click", closeDrawer));
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && drawer?.classList.contains("is-open")) closeDrawer();
  });

  // Search
  const searchToggle = document.getElementById("searchToggle");
  const searchPanel = document.getElementById("searchPanel");
  const searchInput = document.getElementById("searchInput");
  const searchClose = document.getElementById("searchClose");
  const searchResultCount = document.getElementById("searchResultCount");
  searchToggle?.addEventListener("click", () => {
    if (searchPanel.hidden) {
      searchPanel.hidden = false;
      searchToggle.setAttribute("aria-expanded", "true");
      searchInput.focus();
    } else {
      searchPanel.hidden = true;
      searchToggle.setAttribute("aria-expanded", "false");
      searchInput.value = "";
      applyFilters();
    }
  });
  searchClose?.addEventListener("click", () => {
    searchPanel.hidden = true;
    searchToggle.setAttribute("aria-expanded", "false");
    searchInput.value = "";
    applyFilters();
  });

  // Filter, Sort & Search
  const categoryButtons = document.querySelectorAll(".category-item");
  const filterPills = document.querySelectorAll(".filter-pill");
  const productGrid = document.getElementById("productGrid");
  const productCards = Array.from(document.querySelectorAll(".product-card"));
  const filterNote = document.getElementById("filterNote");
  const noResults = document.getElementById("noResults");
  const resetFilterBtn = document.getElementById("resetFilterBtn");
  const favToggle = document.getElementById("favToggle");
  const sortSelect = document.getElementById("sortSelect");
  let activeCategory = "all";

  const CATEGORY_LABELS = {
    all: "Semua koleksi",
    girls: "Girls Collection",
    boys: "Boys & Unisex",
    tops: "Atasan & Kemeja",
    bottoms: "Celana & Rok",
    setelan: "Setelan & Jumpsuit",
    favorites: "Produk Favorit Saya",
  };

  function syncFilterControls() {
    categoryButtons.forEach((btn) => btn.setAttribute("aria-pressed", String((btn.dataset.filter || "all") === activeCategory)));
    filterPills.forEach((pill) => pill.classList.toggle("is-active", (pill.dataset.pill || "all") === activeCategory));
    favToggle?.setAttribute("aria-pressed", String(activeCategory === "favorites"));
  }

  function applySort() {
    if (!sortSelect || !productGrid) return;
    const mode = sortSelect.value;
    const sorted = [...productCards].sort((a, b) => {
      if (mode === "price-asc") return Number(a.dataset.priceNum || 0) - Number(b.dataset.priceNum || 0);
      if (mode === "price-desc") return Number(b.dataset.priceNum || 0) - Number(a.dataset.priceNum || 0);
      if (mode === "name-asc") return (a.querySelector("h3")?.textContent || "").localeCompare(b.querySelector("h3")?.textContent || "", "id");
      return Number(a.dataset.order || 0) - Number(b.dataset.order || 0);
    });
    sorted.forEach((card) => productGrid.appendChild(card));
  }
  sortSelect?.addEventListener("change", applySort);

  function applyFilters() {
    const query = (searchInput?.value || "").trim().toLowerCase();
    let visibleCount = 0;

    productCards.forEach((card) => {
      const cats = (card.dataset.category || "").toLowerCase();
      const name = (card.dataset.name || "").toLowerCase();
      const title = (card.querySelector("h3")?.textContent || "").toLowerCase();
      const isFav = card.querySelector(".fav-btn")?.getAttribute("aria-pressed") === "true";

      let matchesCategory = true;
      if (activeCategory === "favorites") matchesCategory = isFav;
      else if (activeCategory && activeCategory !== "all") matchesCategory = cats.includes(activeCategory);

      const matchesQuery = !query || name.includes(query) || title.includes(query) || cats.includes(query);
      const visible = matchesCategory && matchesQuery;
      card.style.display = visible ? "" : "none";
      if (visible) visibleCount++;
    });

    if (noResults) noResults.hidden = visibleCount !== 0;
    if (searchResultCount) searchResultCount.textContent = query ? `${visibleCount} produk ditemukan untuk "${query}"` : "";
    if (filterNote) {
      const label = CATEGORY_LABELS[activeCategory] || activeCategory;
      filterNote.textContent = !activeCategory || activeCategory === "all"
        ? `Menampilkan semua produk (${visibleCount} koleksi)`
        : `Kategori: ${label} (${visibleCount} produk)`;
    }
    syncFilterControls();
  }

  function setCategoryFilter(filter, shouldScroll = false) {
    activeCategory = (filter === activeCategory && filter !== "all") ? "all" : (filter || "all");
    applyFilters();
    if (shouldScroll) document.getElementById("new-arrivals")?.scrollIntoView({ behavior: "smooth", block: "start" });
  }

  categoryButtons.forEach((btn) => btn.addEventListener("click", () => setCategoryFilter(btn.dataset.filter || "all", true)));
  filterPills.forEach((pill) => pill.addEventListener("click", () => setCategoryFilter(pill.dataset.pill || "all", false)));
  document.querySelectorAll("[data-footer-filter]").forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      activeCategory = link.dataset.footerFilter || "all";
      applyFilters();
      document.getElementById("new-arrivals")?.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  });
  resetFilterBtn?.addEventListener("click", () => {
    activeCategory = "all";
    if (searchInput) searchInput.value = "";
    if (sortSelect) { sortSelect.value = "default"; applySort(); }
    applyFilters();
  });

  let searchDebounce;
  searchInput?.addEventListener("input", () => {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(applyFilters, 120);
  });

  // Color Swatch Switcher
  productCards.forEach((card) => {
    const dots = card.querySelectorAll(".color-dots .dot[data-swatch-img]");
    const primaryImg = card.querySelector(".img-primary");
    if (!primaryImg || dots.length <= 1) return;
    dots.forEach((dot) => {
      dot.addEventListener("click", (e) => {
        e.stopPropagation();
        if (dot.dataset.swatchImg) {
          primaryImg.src = dot.dataset.swatchImg;
          card.classList.add("is-swatch-locked");
        }
        dots.forEach((d) => d.classList.remove("is-active"));
        dot.classList.add("is-active");
      });
    });
  });

  // Favorites
  const favCountEl = document.getElementById("favCount");
  const FAV_STORAGE_KEY = "littlestu_favs_v1";
  let savedFavs = new Set();
  try {
    const raw = localStorage.getItem(FAV_STORAGE_KEY);
    if (raw) JSON.parse(raw).forEach((id) => savedFavs.add(id));
  } catch (_) {}

  function saveFavs() {
    try { localStorage.setItem(FAV_STORAGE_KEY, JSON.stringify([...savedFavs])); } catch (_) {}
  }
  function updateFavBadge() {
    const count = savedFavs.size;
    if (favCountEl) { favCountEl.textContent = String(count); favCountEl.hidden = count === 0; }
    favToggle?.setAttribute("aria-label", `Filter produk favorit (${count} item)`);
  }
  productCards.forEach((card) => {
    const id = card.dataset.id || card.dataset.name;
    const btn = card.querySelector(".fav-btn");
    if (!btn) return;
    if (savedFavs.has(id)) btn.setAttribute("aria-pressed", "true");
    btn.addEventListener("click", (e) => {
      e.stopPropagation();
      const nextState = btn.getAttribute("aria-pressed") !== "true";
      btn.setAttribute("aria-pressed", String(nextState));
      if (nextState) savedFavs.add(id); else savedFavs.delete(id);
      saveFavs();
      updateFavBadge();
      showToast(nextState ? `${card.querySelector("h3")?.textContent || "Produk"} disimpan ke favorit ♥` : "Dihapus dari favorit");
      if (activeCategory === "favorites") applyFilters();
    });
  });
  updateFavBadge();
  favToggle?.addEventListener("click", () => setCategoryFilter("favorites", true));

  // Smart Size Finder
  const calcAge = document.getElementById("calcAge");
  const calcWeight = document.getElementById("calcWeight");
  const calcHeight = document.getElementById("calcHeight");
  const calcResultSize = document.getElementById("calcResultSize");
  const calcResultDesc = document.getElementById("calcResultDesc");
  const calcWaLink = document.getElementById("calcWaLink");
  const sizeRows = document.querySelectorAll("[data-size-row]");
  const fitRadios = document.querySelectorAll('input[name="fitPref"]');

  const SIZE_TIERS = window.LITTLESTU_SIZE_TIERS || [
    { code: "S", ageLabel: "1 – 2 Tahun", maxHeight: 90, maxWeight: 13, maxAge: 2 },
    { code: "M", ageLabel: "2 – 3 Tahun", maxHeight: 100, maxWeight: 16, maxAge: 3 },
    { code: "L", ageLabel: "4 – 5 Tahun", maxHeight: 110, maxWeight: 20, maxAge: 5 },
    { code: "XL / 2L", ageLabel: "6 – 7 Tahun", maxHeight: 120, maxWeight: 25, maxAge: 7 },
    { code: "3L", ageLabel: "8 – 9 Tahun", maxHeight: 130, maxWeight: 30, maxAge: 9 },
    { code: "4L – 5L", ageLabel: "10 – 12 Tahun", maxHeight: 999, maxWeight: 999, maxAge: 99 },
  ];

  let sizeTrackTimer;
  function updateSizeCalculator(shouldTrack = false) {
    if (!calcAge || !calcWeight || !calcHeight) return;
    const age = parseFloat(calcAge.value) || 4;
    const weight = parseFloat(calcWeight.value) || 17;
    const height = parseFloat(calcHeight.value) || 104;
    const loosePref = document.querySelector('input[name="fitPref"]:checked')?.value === "loose";

    let idxH = SIZE_TIERS.findIndex((t) => height <= t.maxHeight);
    let idxW = SIZE_TIERS.findIndex((t) => weight <= t.maxWeight);
    let idxA = SIZE_TIERS.findIndex((t) => age <= t.maxAge);
    if (idxH === -1) idxH = SIZE_TIERS.length - 1;
    if (idxW === -1) idxW = SIZE_TIERS.length - 1;
    if (idxA === -1) idxA = SIZE_TIERS.length - 1;

    let bestIdx = Math.max(idxH, idxW);
    if (idxA > bestIdx) bestIdx = Math.min(SIZE_TIERS.length - 1, Math.round((bestIdx + idxA) / 2));
    if (loosePref && bestIdx < SIZE_TIERS.length - 1) bestIdx += 1;

    const tier = SIZE_TIERS[bestIdx];
    calcResultSize.textContent = `Ukuran ${tier.code}`;
    calcResultDesc.textContent = `Cocok untuk tinggi ~${height} cm & berat ~${weight} kg (${loosePref ? "potongan agak longgar" : `estimasi usia ${tier.ageLabel}`}).`;
    sizeRows.forEach((row) => row.classList.toggle("is-highlighted", row.dataset.sizeRow === tier.code));

    if (calcWaLink) {
      calcWaLink.href = buildWaUrl(`Halo Admin LITTLESTU, saya ingin konsultasi ukuran baju anak (Usia: ${age} thn, Tinggi: ${height} cm, Berat: ${weight} kg). Hasil kalkulator merekomendasikan *Ukuran ${tier.code}*. Apakah sudah pas?`);
    }
    if (shouldTrack) {
      clearTimeout(sizeTrackTimer);
      sizeTrackTimer = setTimeout(() => trackEvent("size_calc", "", tier.code), 800);
    }
  }
  [calcAge, calcWeight, calcHeight].forEach((el) => el?.addEventListener("input", () => updateSizeCalculator(true)));
  fitRadios.forEach((r) => r.addEventListener("change", () => updateSizeCalculator(true)));
  updateSizeCalculator(false);

  // FAQ & Footer Accordions
  document.querySelectorAll(".faq-question").forEach((btn) => {
    btn.addEventListener("click", () => {
      const expanded = btn.getAttribute("aria-expanded") === "true";
      btn.setAttribute("aria-expanded", String(!expanded));
      btn.nextElementSibling?.classList.toggle("is-open", !expanded);
      const icon = btn.querySelector(".faq-icon");
      if (icon) icon.textContent = !expanded ? "–" : "+";
    });
  });
  document.querySelectorAll(".footer-col-toggle").forEach((toggle) => {
    toggle.addEventListener("click", () => {
      const expanded = toggle.getAttribute("aria-expanded") === "true";
      toggle.setAttribute("aria-expanded", String(!expanded));
      toggle.nextElementSibling?.classList.toggle("is-open", !expanded);
    });
  });

  // Newsletter via CI4 API
  const newsletterForm = document.getElementById("newsletterForm");
  const newsletterEmail = document.getElementById("newsletterEmail");
  const newsletterMessage = document.getElementById("newsletterMessage");
  newsletterForm?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const value = newsletterEmail.value.trim();
    newsletterMessage.classList.remove("is-error", "is-success");
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
      newsletterMessage.textContent = "Format email belum sesuai. Contoh: nama@email.com";
      newsletterMessage.classList.add("is-error");
      newsletterEmail.focus();
      return;
    }
    try {
      const res = await fetch(`${CFG.baseUrl}api/newsletter`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email: value }),
      });
      const json = await res.json();
      newsletterMessage.textContent = json.message || "Terima kasih!";
      newsletterMessage.classList.add(json.ok ? "is-success" : "is-error");
      if (json.ok) newsletterForm.reset();
    } catch (_) {
      newsletterMessage.textContent = "Gagal menghubungi server. Coba lagi sebentar.";
      newsletterMessage.classList.add("is-error");
    }
  });

  // Toast
  const toast = document.getElementById("toast");
  let toastTimeout;
  function showToast(message) {
    if (!toast) return;
    clearTimeout(toastTimeout);
    toast.textContent = message;
    toast.hidden = false;
    requestAnimationFrame(() => toast.classList.add("is-visible"));
    toastTimeout = setTimeout(() => {
      toast.classList.remove("is-visible");
      setTimeout(() => { toast.hidden = true; }, 250);
    }, 2200);
  }

  // Reveal animation
  const revealEls = document.querySelectorAll(".reveal");
  if ("IntersectionObserver" in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    revealEls.forEach((el) => observer.observe(el));
  } else {
    revealEls.forEach((el) => el.classList.add("is-visible"));
  }

  const fy = document.getElementById("footerYear");
  if (fy) fy.textContent = new Date().getFullYear();

  // Product Detail Modal + Tracking
  const modal = document.getElementById("productModal");
  const modalOverlay = document.getElementById("productModalOverlay");
  const modalClose = document.getElementById("productModalClose");
  const modalTrack = document.getElementById("productModalTrack");
  const modalDots = document.getElementById("sliderDots");
  const modalPrev = document.getElementById("sliderPrev");
  const modalNext = document.getElementById("sliderNext");
  const modalTitle = document.getElementById("productModalTitle");
  const modalPrice = document.getElementById("productModalPrice");
  const modalColors = document.getElementById("productModalColors");
  const modalSizes = document.getElementById("productModalSizes");
  const modalSize = document.getElementById("productModalSize");
  const modalDesc = document.getElementById("productModalDesc");
  const modalShopee = document.getElementById("productModalShopee");
  const modalTiktok = document.getElementById("productModalTiktok");
  const modalWa = document.getElementById("productModalWa");
  const modalWaText = document.getElementById("productModalWaText");
  const modalPairBox = document.getElementById("modalPairBox");
  const modalPairList = document.getElementById("modalPairList");

  let modalImages = [];
  let modalIndex = 0;
  let lastFocusedEl = null;
  let currentModalProduct = null;
  let selectedModalColor = "";
  let selectedModalSize = "";

  function updateModalWhatsAppLink() {
    if (!currentModalProduct || !modalWa) return;
    const name = currentModalProduct.name || "Produk LITTLESTU";
    const colorPart = selectedModalColor ? ` warna *${selectedModalColor}*` : "";
    const sizePart = selectedModalSize ? ` ukuran *${selectedModalSize}*` : "";
    modalWa.href = buildWaUrl(`Halo Admin LITTLESTU, saya tertarik memesan *${name}*${colorPart}${sizePart}. Apakah stoknya masih tersedia?`);
    if (modalWaText) modalWaText.textContent = `Tanya Stok ${name} (${selectedModalSize || "Pilih Size"}) via WhatsApp`;
  }

  function renderSlides(images) {
    modalTrack.innerHTML = "";
    modalDots.innerHTML = "";
    images.forEach((src, i) => {
      const img = document.createElement("img");
      img.src = src;
      img.alt = `Foto produk ${modalTitle.textContent} ${i + 1}`;
      img.onerror = () => { img.src = CFG.fallbackImg; };
      modalTrack.appendChild(img);

      const dot = document.createElement("button");
      dot.type = "button";
      dot.setAttribute("aria-label", `Lihat foto ${i + 1}`);
      dot.addEventListener("click", () => goToSlide(i));
      modalDots.appendChild(dot);
    });
    const one = images.length <= 1;
    modalPrev.hidden = one;
    modalNext.hidden = one;
    modalDots.hidden = one;
  }

  function goToSlide(index) {
    modalIndex = (index + modalImages.length) % modalImages.length;
    modalTrack.style.transform = `translateX(-${modalIndex * 100}%)`;
    modalDots.querySelectorAll("button").forEach((dot, i) => dot.classList.toggle("is-active", i === modalIndex));
  }

  function renderMixAndMatch(pairSlugs) {
    if (!modalPairBox || !modalPairList) return;
    modalPairList.innerHTML = "";
    const cards = (pairSlugs || [])
      .map((slug) => document.querySelector(`.product-card[data-id="${slug}"]`))
      .filter(Boolean);
    if (cards.length === 0) { modalPairBox.hidden = true; return; }

    cards.forEach((card) => {
      const trigger = card.querySelector(".js-product-detail");
      const imgSrc = card.querySelector(".img-primary")?.getAttribute("src") || CFG.fallbackImg;
      const title = card.querySelector("h3")?.textContent || "";
      const price = card.querySelector(".product-price")?.textContent || "";
      const btn = document.createElement("button");
      btn.type = "button";
      btn.className = "pair-card";
      btn.innerHTML = `<img src="${imgSrc}" alt="${title}" onerror="this.src='${CFG.fallbackImg}'" /><div class="pair-card-info"><span class="pair-card-name">${title}</span><span class="pair-card-price">${price}</span></div>`;
      btn.addEventListener("click", () => {
        if (trigger) openProductModal(extractDetail(trigger, card));
      });
      modalPairList.appendChild(btn);
    });
    modalPairBox.hidden = false;
  }

  function openProductModal(data) {
    if (!modal.classList.contains("is-open")) lastFocusedEl = document.activeElement;
    currentModalProduct = data;
    trackEvent("product_view", data.id);

    modalTitle.textContent = data.name || "";
    modalPrice.textContent = data.price || "";
    modalSize.textContent = data.size || "";
    modalDesc.textContent = data.desc || "";
    modalShopee.href = data.shopee || CFG.shopeeUrl;
    modalTiktok.href = data.tiktok || CFG.tiktokUrl;

    modalColors.innerHTML = "";
    const colors = data.colors || [];
    selectedModalColor = colors[0]?.name || "";
    colors.forEach((c, idx) => {
      const item = document.createElement("button");
      item.type = "button";
      item.className = `product-modal-color-item${idx === 0 ? " is-selected" : ""}`;
      item.innerHTML = `<span class="dot" style="--dot:${c.hex}"></span><span>${c.name}</span>`;
      item.addEventListener("click", () => {
        selectedModalColor = c.name;
        modalColors.querySelectorAll(".product-modal-color-item").forEach((el) => el.classList.remove("is-selected"));
        item.classList.add("is-selected");
        if (idx < modalImages.length) goToSlide(idx);
        updateModalWhatsAppLink();
      });
      modalColors.appendChild(item);
    });

    if (modalSizes) {
      modalSizes.innerHTML = "";
      const sizes = (data.sizes || "S,M,L,2L,3L,4L").split(",").map((s) => s.trim()).filter(Boolean);
      selectedModalSize = sizes.includes("L") ? "L" : (sizes[0] || "L");
      sizes.forEach((sz) => {
        const chip = document.createElement("button");
        chip.type = "button";
        chip.className = `size-chip${sz === selectedModalSize ? " is-selected" : ""}`;
        chip.textContent = sz;
        chip.addEventListener("click", () => {
          selectedModalSize = sz;
          modalSizes.querySelectorAll(".size-chip").forEach((el) => el.classList.remove("is-selected"));
          chip.classList.add("is-selected");
          updateModalWhatsAppLink();
        });
        modalSizes.appendChild(chip);
      });
    }

    renderMixAndMatch(data.pairSlugs);
    updateModalWhatsAppLink();

    modalImages = data.images && data.images.length ? data.images : [CFG.fallbackImg];
    renderSlides(modalImages);
    goToSlide(0);

    modal.hidden = false;
    modalOverlay.hidden = false;
    requestAnimationFrame(() => {
      modal.classList.add("is-open");
      modalOverlay.classList.add("is-visible");
    });
    modal.setAttribute("aria-hidden", "false");
    document.body.classList.add("modal-open");
    modalClose.focus();
  }

  function closeProductModal() {
    modal.classList.remove("is-open");
    modalOverlay.classList.remove("is-visible");
    modal.setAttribute("aria-hidden", "true");
    document.body.classList.remove("modal-open");
    setTimeout(() => { modal.hidden = true; modalOverlay.hidden = true; }, 350);
    if (lastFocusedEl) lastFocusedEl.focus();
  }

  modalShopee?.addEventListener("click", () => currentModalProduct && trackEvent("click_shopee", currentModalProduct.id));
  modalTiktok?.addEventListener("click", () => currentModalProduct && trackEvent("click_tiktok", currentModalProduct.id));
  modalWa?.addEventListener("click", () => currentModalProduct && trackEvent("click_wa", currentModalProduct.id, selectedModalSize));

  function extractDetail(btn, cardEl) {
    const parentCard = cardEl || btn.closest(".product-card");
    let images = [];
    let colors = [];
    let pairSlugs = [];
    try { images = JSON.parse(btn.dataset.images || "[]"); } catch (_) {}
    try { colors = JSON.parse(btn.dataset.colors || "[]"); } catch (_) {}
    try { pairSlugs = JSON.parse(parentCard?.dataset.pairSlugs || "[]"); } catch (_) {}

    return {
      id: btn.dataset.id || parentCard?.dataset.id || "",
      name: btn.dataset.name,
      price: btn.dataset.price,
      images,
      colors,
      size: btn.dataset.size,
      sizes: btn.dataset.sizes || "S,M,L,2L,3L,4L",
      desc: btn.dataset.desc,
      shopee: btn.dataset.shopee,
      tiktok: btn.dataset.tiktok,
      pairSlugs,
    };
  }

  function openProductById(slug) {
    const card = document.querySelector(`.product-card[data-id="${slug}"]`);
    const trigger = card?.querySelector(".js-product-detail");
    if (card && trigger) openProductModal(extractDetail(trigger, card));
  }

  document.querySelectorAll(".js-product-detail").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      openProductModal(extractDetail(btn));
    });
  });
  document.querySelectorAll(".js-open-by-id").forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.preventDefault();
      e.stopPropagation();
      if (btn.dataset.targetId) openProductById(btn.dataset.targetId);
    });
  });
  productCards.forEach((card) => {
    const media = card.querySelector(".product-media");
    const detailBtn = card.querySelector(".js-product-detail");
    media?.addEventListener("click", (e) => {
      if (e.target.closest(".fav-btn")) return;
      if (detailBtn) openProductModal(extractDetail(detailBtn, card));
    });
  });

  modalClose?.addEventListener("click", closeProductModal);
  modalOverlay?.addEventListener("click", closeProductModal);
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && modal?.classList.contains("is-open")) closeProductModal();
  });
  modalPrev?.addEventListener("click", () => goToSlide(modalIndex - 1));
  modalNext?.addEventListener("click", () => goToSlide(modalIndex + 1));

  // Lookbook Slider
  const featuredSlider = document.getElementById("featuredSlider");
  const featuredTrack = featuredSlider?.querySelector(".featured-track");
  const featuredSlides = featuredSlider?.querySelectorAll(".featured-slide");
  const prevButton = featuredSlider?.querySelector(".featured-arrow--prev");
  const nextButton = featuredSlider?.querySelector(".featured-arrow--next");
  const dots = featuredSlider?.querySelectorAll(".featured-dots button");

  if (featuredSlider && featuredTrack && featuredSlides && featuredSlides.length > 1) {
    let currentSlide = 0;
    function updateFeaturedSlider() {
      featuredTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
      dots?.forEach((dot, idx) => dot.classList.toggle("active", idx === currentSlide));
    }
    dots?.forEach((dot, idx) => dot.addEventListener("click", () => { currentSlide = idx; updateFeaturedSlider(); }));
    nextButton?.addEventListener("click", () => { currentSlide = (currentSlide + 1) % featuredSlides.length; updateFeaturedSlider(); });
    prevButton?.addEventListener("click", () => { currentSlide = (currentSlide - 1 + featuredSlides.length) % featuredSlides.length; updateFeaturedSlider(); });
  }
})();
