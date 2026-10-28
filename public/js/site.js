/**
 * Certified Drug Test Centers - Client-side Interactive Logic
 */

document.addEventListener('DOMContentLoaded', function () {
  // Mobile Navigation Toggle
  const navToggle = document.getElementById('mobileNavToggle');
  const navMenu = document.getElementById('navMenu');
  if (navToggle && navMenu) {
    navToggle.addEventListener('click', function () {
      navMenu.classList.toggle('open');
      const isExpanded = navMenu.classList.contains('open');
      navToggle.setAttribute('aria-expanded', isExpanded);
    });
  }

  // Interactive ZIP Code Search Logic
  const zipForms = document.querySelectorAll('.zip-search-form');
  zipForms.forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const input = form.querySelector('.zip-input');
      const feedback = form.closest('.hero-zip-card, .zip-search-wrapper')?.querySelector('.zip-feedback-banner');
      if (!input || !feedback) return;

      const zipVal = input.value.trim();
      if (!zipVal || zipVal.length < 5) {
        feedback.innerHTML = '<span style="color: #c1121f; font-weight:700;">⚠️ Please enter a valid 5-digit US ZIP Code.</span>';
        feedback.classList.add('show');
        return;
      }

      feedback.innerHTML = '<span style="color:#0B2545;">🔍 Searching 20,000+ Quest & Labcorp sites near ' + zipVal + '...</span>';
      feedback.classList.add('show');

      fetch('/api/locations/search?zip=' + encodeURIComponent(zipVal))
        .then(res => res.json())
        .then(data => {
          if (data.success && data.locations && data.locations.length > 0) {
            const loc = data.locations[0];
            feedback.innerHTML = `
              <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                <div>
                  <strong>📍 Nearest Certified Site: ${loc.name}</strong><br>
                  <span style="font-size:12.5px; color:#475569;">${loc.address1}, ${loc.city}, ${loc.state} ${loc.zip}</span><br>
                  <span style="font-size:12px; color:#16a34a; font-weight:600;">● Walk-Ins Accepted: ${loc.hours || 'Mon-Fri 8:00 AM - 5:00 PM'}</span>
                </div>
                <a href="/checkout?zip=${encodeURIComponent(loc.zip)}" class="btn btn-primary btn-sm">
                  Register at This Center →
                </a>
              </div>
            `;
          } else {
            feedback.innerHTML = `
              <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                <div>
                  <strong>📍 Quest & Labcorp Certified Centers Serving ZIP ${zipVal}</strong><br>
                  <span style="font-size:12px; color:#16a34a; font-weight:600;">● Same-Day Walk-Ins Accepted Nationwide</span>
                </div>
                <a href="/checkout?zip=${encodeURIComponent(zipVal)}" class="btn btn-primary btn-sm">
                  Schedule Test Online →
                </a>
              </div>
            `;
          }
        })
        .catch(err => {
          feedback.innerHTML = `
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
              <div>
                <strong>📍 Quest Diagnostics & Labcorp Partner Facilities Serving ZIP ${zipVal}</strong><br>
                <span style="font-size:12px; color:#16a34a; font-weight:600;">● No Appointment Needed</span>
              </div>
              <a href="/checkout?zip=${encodeURIComponent(zipVal)}" class="btn btn-primary btn-sm">
                Schedule Test Online →
              </a>
            </div>
          `;
        });
    });
  });

  // Product Filter Tabs
  const filterBtns = document.querySelectorAll('.filter-tab-btn');
  const productCards = document.querySelectorAll('.product-card');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', function () {
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');

      const filterCategory = this.getAttribute('data-filter');

      productCards.forEach(card => {
        const cardCategory = card.getAttribute('data-category');
        if (filterCategory === 'all' || cardCategory === filterCategory) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  // Substance Search Checker (Design 2 Feature)
  const substanceInput = document.getElementById('substanceSearchInput');
  const substanceResult = document.getElementById('substanceMatchResult');
  const substancePills = document.querySelectorAll('.substance-quick-pill');

  const substanceMatrix = {
    'marijuana': { panels: ['5 Panel ($89.99)', '10 Panel ($109.99)', '12 Panel ($139.99)', 'Hair Follicle ($169.99)'], note: 'Standard THC metabolite detected across all basic and expanded panels.' },
    'thc': { panels: ['5 Panel ($89.99)', '10 Panel ($109.99)', '12 Panel ($139.99)', 'Hair Follicle ($169.99)'], note: 'Standard THC metabolite detected across all basic and expanded panels.' },
    'cocaine': { panels: ['5 Panel ($89.99)', '10 Panel ($109.99)', '12 Panel ($139.99)', 'Hair Follicle ($169.99)'], note: 'Benzoylecgonine cocaine metabolite screened on all panels.' },
    'amphetamines': { panels: ['5 Panel ($89.99)', '10 Panel ($109.99)', '12 Panel ($139.99)', 'Hair Follicle ($169.99)'], note: 'Includes amphetamine, methamphetamine, and MDMA/ecstasy.' },
    'meth': { panels: ['5 Panel ($89.99)', '10 Panel ($109.99)', '12 Panel ($139.99)', 'Hair Follicle ($169.99)'], note: 'Detected in all panels under the amphetamine class.' },
    'opiates': { panels: ['5 Panel ($89.99)', '10 Panel ($109.99)', '12 Panel ($139.99)', 'Hair Follicle ($169.99)'], note: 'Includes morphine, codeine, and 6-acetylmorphine (heroin).' },
    'oxycodone': { panels: ['5 Panel + Expanded Opiates ($99.99)', '10 Panel + Exp Opiates ($119.99)', '12 Panel ($139.99)'], note: 'Requires Expanded Opiates panel or 12-Panel (Percocet, OxyContin).' },
    'hydrocodone': { panels: ['5 Panel + Expanded Opiates ($99.99)', '10 Panel + Exp Opiates ($119.99)', '12 Panel ($139.99)'], note: 'Requires Expanded Opiates panel or 12-Panel (Vicodin, Norco, Lortab).' },
    'xanax': { panels: ['10 Panel ($109.99)', '12 Panel ($139.99)', 'Hair 10-Panel ($249.99)'], note: 'Benzodiazepine class detected starting in 10-Panel tests.' },
    'valium': { panels: ['10 Panel ($109.99)', '12 Panel ($139.99)'], note: 'Benzodiazepine class detected in 10-Panel and 12-Panel tests.' },
    'barbiturates': { panels: ['10 Panel ($109.99)', '12 Panel ($139.99)'], note: 'Sedative/hypnotic detected starting in 10-Panel tests.' },
    'tramadol': { panels: ['12 Panel Comprehensive ($139.99)'], note: 'Requires a 12-Panel Comprehensive test.' },
    'fentanyl': { panels: ['12 Panel + Specialty Fentanyl Add-On ($159.99)', 'Medical Professional Panel ($159.99)'], note: 'Synthetic opioid requires specialized high-sensitivity panel.' },
    'alcohol': { panels: ['Breath Alcohol EBT ($89.99)', 'EtG Urine 80-Hour ($89.99)'], note: 'Available via instant Breathalyzer or 80-hour EtG urine metabolite test.' }
  };

  function checkSubstance(query) {
    if (!substanceResult) return;
    const cleanQuery = query.toLowerCase().trim();
    if (!cleanQuery) {
      substanceResult.classList.remove('active');
      return;
    }

    let matchKey = Object.keys(substanceMatrix).find(k => k.includes(cleanQuery) || cleanQuery.includes(k));

    if (matchKey) {
      const data = substanceMatrix[matchKey];
      substanceResult.innerHTML = `
        <div style="font-weight:700; color:#0b2545; margin-bottom:4px;">
          ✓ Found match for "${query}":
        </div>
        <div style="color:#475569; margin-bottom:8px;">${data.note}</div>
        <div style="font-weight:600; color:#c1121f; font-size:13px;">Recommended Tests:</div>
        <ul style="margin:6px 0 10px 20px; font-size:13.5px; color:#1e293b;">
          ${data.panels.map(p => `<li>${p}</li>`).join('')}
        </ul>
        <button type="button" class="btn btn-primary btn-sm" onclick="scrollToPanels()">View Matching Panels →</button>
      `;
      substanceResult.classList.add('active');
    } else {
      substanceResult.innerHTML = `
        <div style="font-weight:600; color:#0b2545;">
          Checking for "${query}"? Most prescription medications and pain relievers require a <strong>10 Panel + Exp Opiates</strong> or <strong>12 Panel Comprehensive</strong>.
        </div>
        <div style="margin-top:8px;">
          <a href="tel:18002214291" style="color:#c1121f; font-weight:700; text-decoration:underline;">Call (800) 221-4291</a> to confirm exact laboratory coverage.
        </div>
      `;
      substanceResult.classList.add('active');
    }
  }

  if (substanceInput) {
    substanceInput.addEventListener('input', function () {
      checkSubstance(this.value);
    });
  }

  substancePills.forEach(pill => {
    pill.addEventListener('click', function () {
      const substance = this.getAttribute('data-substance');
      if (substanceInput) substanceInput.value = substance;
      checkSubstance(substance);
    });
  });

  // State Search Filter
  const stateSearchInput = document.getElementById('stateSearchInput');
  const stateChips = document.querySelectorAll('.state-chip');
  if (stateSearchInput) {
    stateSearchInput.addEventListener('input', function () {
      const q = this.value.toLowerCase().trim();
      stateChips.forEach(chip => {
        const stateName = chip.getAttribute('data-state')?.toLowerCase() || '';
        if (!q || stateName.includes(q)) {
          chip.style.display = 'flex';
        } else {
          chip.style.display = 'none';
        }
      });
    });
  }

  // Instant Test Estimator (Design 2 Feature)
  const estReason = document.getElementById('estReason');
  const estSpecimen = document.getElementById('estSpecimen');
  const estPriceDisplay = document.getElementById('estPriceVal');
  const estPanelNameDisplay = document.getElementById('estPanelName');
  const estTurnaroundDisplay = document.getElementById('estTurnaround');

  const estimatorData = {
    'urine-5': { name: '5 Panel Non-DOT Urine Test', price: '$89.99', turnaround: '1 - 2 Business Days' },
    'urine-10': { name: '10 Panel Comprehensive Urine Test', price: '$109.99', turnaround: '1 - 2 Business Days' },
    'urine-12': { name: '12 Panel Comprehensive Urine Test', price: '$139.99', turnaround: '24 - 48 Hours' },
    'dot-5': { name: '5 Panel DOT Urine Drug Screen', price: '$99.99', turnaround: '24 - 48 Hours' },
    'hair-5': { name: 'Hair Follicle 5-Panel (90 Days)', price: '$169.99', turnaround: '2 - 3 Business Days' },
    'alcohol-breath': { name: 'DOT/Non-DOT Breath Alcohol Test', price: '$89.99', turnaround: 'Instant Reading' },
    'physical-dot': { name: 'DOT Physical Examination (NRCME)', price: '$159.99', turnaround: 'Same-Day Card' }
  };

  function updateEstimator() {
    if (!estSpecimen || !estPriceDisplay) return;
    const selectedKey = estSpecimen.value;
    const match = estimatorData[selectedKey] || estimatorData['urine-5'];

    estPriceDisplay.textContent = match.price;
    if (estPanelNameDisplay) estPanelNameDisplay.textContent = match.name;
    if (estTurnaroundDisplay) estTurnaroundDisplay.textContent = 'Turnaround: ' + match.turnaround;
  }

  if (estSpecimen) {
    estSpecimen.addEventListener('change', updateEstimator);
  }
  if (estReason) {
    estReason.addEventListener('change', function () {
      if (this.value === 'dot' && estSpecimen) {
        estSpecimen.value = 'dot-5';
      }
      updateEstimator();
    });
  }
});

// Modal Dialog Helpers
function openOrderModal(productId, productName, price) {
  const modal = document.getElementById('orderModal');
  if (!modal) return;
  const nameEl = document.getElementById('modalProductName');
  const priceEl = document.getElementById('modalProductPrice');
  const testInput = document.getElementById('modalInputTestName');

  if (nameEl) nameEl.textContent = productName || 'Drug Test Registration';
  if (priceEl) priceEl.textContent = price ? '$' + Number(price).toFixed(2) : '$89.99';
  if (testInput) testInput.value = productName;

  if (typeof modal.showModal === 'function') {
    modal.showModal();
  } else {
    modal.style.display = 'block';
  }
}

function closeOrderModal() {
  const modal = document.getElementById('orderModal');
  if (!modal) return;
  if (typeof modal.close === 'function') {
    modal.close();
  } else {
    modal.style.display = 'none';
  }
}

function openMobileQuoteModal() {
  const modal = document.getElementById('mobileQuoteModal');
  if (!modal) return;
  if (typeof modal.showModal === 'function') {
    modal.showModal();
  } else {
    modal.style.display = 'block';
  }
}

function closeMobileQuoteModal() {
  const modal = document.getElementById('mobileQuoteModal');
  if (!modal) return;
  if (typeof modal.close === 'function') {
    modal.close();
  } else {
    modal.style.display = 'none';
  }
}

function scrollToPanels() {
  const el = document.getElementById('pricing-panels') || document.getElementById('products-section');
  if (el) el.scrollIntoView({ behavior: 'smooth' });
}

// ==========================================================================
// Global Interactive Search Modal & Cmd+K Shortcut
// ==========================================================================
let searchDebounceTimer = null;

function openGlobalSearch() {
  const modal = document.getElementById('globalSearchModal');
  if (!modal) return;
  if (typeof modal.showModal === 'function') {
    modal.showModal();
  } else {
    modal.style.display = 'block';
  }
  const input = document.getElementById('globalSearchInput');
  if (input) {
    setTimeout(() => input.focus(), 50);
    if (!input.value.trim()) {
      executeProductSearch('panel'); // Preload popular panels
    }
  }
}

function closeGlobalSearch() {
  const modal = document.getElementById('globalSearchModal');
  if (!modal) return;
  if (typeof modal.close === 'function') {
    modal.close();
  } else {
    modal.style.display = 'none';
  }
}

function searchTag(term) {
  const input = document.getElementById('globalSearchInput');
  if (input) {
    input.value = term;
    executeProductSearch(term);
  }
}

function executeProductSearch(query) {
  const resultsContainer = document.getElementById('globalSearchResults');
  if (!resultsContainer) return;

  resultsContainer.innerHTML = '<div class="search-empty-state">Searching certified drug tests & panels...</div>';

  fetch('/api/products/search?q=' + encodeURIComponent(query))
    .then(res => res.json())
    .then(data => {
      if (!data.results || data.results.length === 0) {
        resultsContainer.innerHTML = `
          <div class="search-empty-state">
            No exact tests found matching <strong>"${query}"</strong>.<br>
            <span style="font-size:12px; margin-top:6px; display:inline-block;">Call our toxicologists at <a href="tel:18002214291" style="color:#C1121F; font-weight:700;">(800) 221-4291</a> to customize a custom substance panel.</span>
          </div>
        `;
        return;
      }

      let html = '';
      data.results.forEach(item => {
        const panelsHtml = item.included_panels && item.included_panels.length > 0
          ? item.included_panels.map(p => `<span style="background:#F1F5F9; color:#475569; padding:2px 6px; border-radius:4px; font-size:11px;">${p}</span>`).join(' ')
          : '';

        html += `
          <div class="search-result-row">
            <div class="search-result-info">
              <a href="${item.url}" class="search-result-title" style="display:block; text-decoration:none;">${item.name}</a>
              <div class="search-result-meta">
                <span style="background:#E0F2FE; color:#0369A1; font-weight:700; padding:2px 6px; border-radius:4px;">${item.specimen_type}</span>
                ${item.dot_required ? '<span style="background:#FEE2E2; color:#B91C1C; font-weight:700; padding:2px 6px; border-radius:4px;">DOT</span>' : ''}
                <span>Turnaround: ${item.turnaround_time}</span>
              </div>
              ${panelsHtml ? `<div style="display:flex; gap:4px; flex-wrap:wrap; margin-top:6px;">${panelsHtml}</div>` : ''}
            </div>
            <div class="search-result-action">
              <div class="search-result-price">$${item.price}</div>
              <a href="${item.checkout_url}" class="btn btn-primary btn-sm" style="margin-top:4px; font-size:12px; padding:5px 12px;">Order Now &rarr;</a>
            </div>
          </div>
        `;
      });
      resultsContainer.innerHTML = html;
    })
    .catch(err => {
      resultsContainer.innerHTML = '<div class="search-empty-state" style="color:#C1121F;">Error searching tests. Please try again or call (800) 221-4291.</div>';
    });
}

// Global Keyboard Shortcut: Cmd+K / Ctrl+K
document.addEventListener('keydown', function (e) {
  if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
    e.preventDefault();
    openGlobalSearch();
  }
});

// Setup Live Search Input Listener
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('globalSearchInput');
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      const q = this.value.trim();
      clearTimeout(searchDebounceTimer);
      if (!q) {
        executeProductSearch('panel');
        return;
      }
      searchDebounceTimer = setTimeout(() => {
        executeProductSearch(q);
      }, 200);
    });
  }
});

// ==========================================================================
// Global Fast ZIP Collection Center Locator Modal
// ==========================================================================
function openZipModal() {
  const modal = document.getElementById('globalZipModal');
  if (!modal) return;
  if (typeof modal.showModal === 'function') {
    modal.showModal();
  } else {
    modal.style.display = 'block';
  }
  const input = document.getElementById('modalZipInput');
  if (input) setTimeout(() => input.focus(), 50);
}

function closeZipModal() {
  const modal = document.getElementById('globalZipModal');
  if (!modal) return;
  if (typeof modal.close === 'function') {
    modal.close();
  } else {
    modal.style.display = 'none';
  }
}

function lookupZipModal() {
  const input = document.getElementById('modalZipInput');
  const resultsContainer = document.getElementById('modalZipResultsList');
  if (!input || !resultsContainer) return;

  const zip = input.value.trim();
  if (!zip || zip.length < 5) return;

  resultsContainer.innerHTML = '<div style="text-align:center; padding:16px; color:#0B2545;">Searching 20,000+ Quest & Labcorp sites near ' + zip + '...</div>';

  fetch('/api/locations/search?zip=' + encodeURIComponent(zip))
    .then(res => res.json())
    .then(data => {
      if (data.success && data.locations && data.locations.length > 0) {
        let html = '';
        data.locations.slice(0, 5).forEach((loc, idx) => {
          html += `
            <div class="global-zip-item">
              <div>
                <div class="global-zip-item-title">${idx + 1}. ${loc.name}</div>
                <div class="global-zip-item-address">${loc.address1}, ${loc.city}, ${loc.state} ${loc.zip}</div>
                <div class="global-zip-item-hours">● Walk-Ins Accepted: ${loc.hours || 'Mon-Fri 8:00 AM - 5:00 PM'}</div>
              </div>
              <a href="/checkout?zip=${encodeURIComponent(loc.zip)}" class="btn btn-primary btn-sm" style="white-space:nowrap;">
                Register Here &rarr;
              </a>
            </div>
          `;
        });
        resultsContainer.innerHTML = html;
      } else {
        resultsContainer.innerHTML = `
          <div class="global-zip-item">
            <div>
              <div class="global-zip-item-title">Quest Diagnostics & Labcorp Partner Facilities Serving ZIP ${zip}</div>
              <div class="global-zip-item-address">Certified collection network covering all 50 states</div>
              <div class="global-zip-item-hours">● Walk-in registration available immediately upon online checkout</div>
            </div>
            <a href="/checkout?zip=${encodeURIComponent(zip)}" class="btn btn-primary btn-sm" style="white-space:nowrap;">
              Schedule Test Online &rarr;
            </a>
          </div>
        `;
      }
    })
    .catch(err => {
      resultsContainer.innerHTML = '<div style="text-align:center; padding:16px; color:#C1121F;">Unable to lookup locations. Please call (800) 221-4291 for immediate dispatch.</div>';
    });
}

