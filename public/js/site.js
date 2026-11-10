/**
 * Certified Drug Test Centers - Client-side Interactive Logic
 */

document.addEventListener('DOMContentLoaded', function () {
  // Mobile Navigation Toggle & Accordion Submenus
  const navToggle = document.getElementById('mobileNavToggle');
  const navMenu = document.getElementById('navMenu');
  if (navToggle && navMenu) {
    navToggle.addEventListener('click', function () {
      const isOpen = navMenu.classList.toggle('open');
      navToggle.classList.toggle('open', isOpen);
      navToggle.setAttribute('aria-expanded', isOpen);
    });

    // Mobile Accordion Dropdown Submenus
    const dropdownItems = navMenu.querySelectorAll('.nav-item.has-dropdown');
    dropdownItems.forEach(item => {
      const link = item.querySelector('.nav-link');
      if (link) {
        link.addEventListener('click', function (e) {
          if (window.innerWidth <= 1100) {
            e.preventDefault();
            const wasOpen = item.classList.contains('open');
            dropdownItems.forEach(other => {
              if (other !== item) other.classList.remove('open');
            });
            item.classList.toggle('open', !wasOpen);
          }
        });
      }
    });

    // Close mobile drawer when clicking outside
    document.addEventListener('click', function (e) {
      if (window.innerWidth <= 1100 && navMenu.classList.contains('open')) {
        if (!navMenu.contains(e.target) && !navToggle.contains(e.target)) {
          navMenu.classList.remove('open');
          navToggle.classList.remove('open');
          navToggle.setAttribute('aria-expanded', 'false');
        }
      }
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
            let locationsHtml = `
              <div style="margin-bottom:10px;">
                <div style="font-weight:800; color:#0B2545; font-size:14px; margin-bottom:4px;">
                  📍 Found ${data.locations.length} Certified Collection Centers Near ${zipVal}:
                </div>
                <div style="font-size:11.5px; color:#92400E; background:#FFFBEB; padding:5px 10px; border-radius:6px; border:1px solid #FDE68A;">
                  <strong>Pre-registration required:</strong> You must receive a registration form/donor pass prior to proceeding to any testing center.
                </div>
              </div>
              <div style="display:flex; flex-direction:column; gap:10px; max-height:360px; overflow-y:auto; padding-right:4px;">
            `;

            data.locations.forEach((loc, idx) => {
              locationsHtml += `
                <div style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:8px; padding:12px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
                  <div style="flex:1; min-width:220px;">
                    <div style="display:flex; align-items:center; gap:6px; margin-bottom:3px;">
                      <span style="background:#E0F2FE; color:#0369A1; font-size:10px; font-weight:800; padding:2px 6px; border-radius:4px; text-transform:uppercase;">${loc.provider || 'Certified'}</span>
                      <strong style="color:#0B2545; font-size:13.5px;">${loc.name}</strong>
                    </div>
                    <div style="font-size:12px; color:#475569;">${loc.address}, ${loc.city}, ${loc.state} ${loc.zip}</div>
                    <div style="font-size:11px; color:#64748B; margin-top:2px;">🕒 ${loc.hours || 'Mon-Fri 8:00 AM - 5:00 PM'}</div>
                  </div>
                  <div style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                    <a href="tel:18009854339" class="btn btn-sm" style="background:#0B2545; color:#fff; border-color:#0B2545; padding:6px 10px; font-size:11.5px; text-decoration:none;">
                      📞 Call Now
                    </a>
                    <a href="/checkout?location_id=${loc.id}&zip=${encodeURIComponent(loc.zip)}" class="btn btn-primary btn-sm" style="padding:6px 12px; font-size:12px;">
                      Schedule at This Center &rarr;
                    </a>
                  </div>
                </div>
              `;
            });

            locationsHtml += `</div>`;
            feedback.innerHTML = locationsHtml;
          } else {
            feedback.innerHTML = `
              <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                <div>
                  <strong>📍 Certified Centers Serving ZIP ${zipVal}</strong><br>
                  <div style="font-size:11.5px; color:#92400E; background:#FFFBEB; padding:3px 8px; border-radius:4px; margin-top:4px; border:1px solid #FDE68A;">
                    <strong>Pre-registration required:</strong> You must receive a registration form/donor pass prior to proceeding to the testing center.
                  </div>
                </div>
                <a href="/checkout?zip=${encodeURIComponent(zipVal)}" class="btn btn-primary btn-sm">
                  Schedule Test Online &rarr;
                </a>
              </div>
            `;
          }
        })
        .catch(err => {
          feedback.innerHTML = `
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
              <div>
                <strong>📍 Certified Collection Facilities Serving ZIP ${zipVal}</strong><br>
                <div style="font-size:11.5px; color:#92400E; background:#FFFBEB; padding:3px 8px; border-radius:4px; margin-top:4px; border:1px solid #FDE68A;">
                  <strong>Pre-registration required:</strong> You must receive a registration form/donor pass prior to proceeding to the testing center.
                </div>
              </div>
              <a href="/checkout?zip=${encodeURIComponent(zipVal)}" class="btn btn-primary btn-sm">
                Schedule Test Online &rarr;
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
          <a href="tel:18009854339" style="color:#c1121f; font-weight:700; text-decoration:underline;">Call (800)-985-4339</a> to confirm exact laboratory coverage.
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
  const estMethod = document.getElementById('estMethod');
  const estSpecimen = document.getElementById('estSpecimen');
  const estPriceDisplay = document.getElementById('estPriceVal');
  const estPanelNameDisplay = document.getElementById('estPanelName');
  const estTurnaroundDisplay = document.getElementById('estTurnaround');

  const estimatorMethodPanels = {
    urine: [
      { value: '5-panel-non-dot', name: '5 Panel Non-DOT Urine Test (Basic)', price: '89.99', turnaround: '24-48 hours' },
      { value: '10-panel', name: '10 Panel Comprehensive Urine Test', price: '109.99', turnaround: '24-48 hours' },
      { value: '12-panel-comprehensive', name: '12 Panel Maximum Coverage Urine Test', price: '139.99', turnaround: '24-48 hours' },
      { value: '5-panel-expanded-opiates', name: '5 Panel + Expanded Opiates Urine Test', price: '99.99', turnaround: '24-48 hours' },
      { value: '10-panel-expanded-opiates', name: '10 Panel + Expanded Opiates Urine Test', price: '119.99', turnaround: '24-48 hours' },
    ],
    dot: [
      { value: '5-panel-dot', name: '5 Panel DOT Federal Urine Screen', price: '99.99', turnaround: '24-48 hours' },
      { value: 'dot-breath-alcohol', name: 'Breath Alcohol Test (BAT / EBT)', price: '89.99', turnaround: 'Instant Reading' },
      { value: '5-panel-dot-breath-alcohol', name: '5 Panel DOT & Breath Alcohol Combo', price: '169.99', turnaround: 'Same-Day / 24-48 hrs' },
      { value: 'dot-physical', name: 'DOT Physical Exam (NRCME Doctor)', price: '159.99', turnaround: 'Same-Day Card' },
      { value: 'dot-drug-test-physical', name: 'DOT Drug Test & Physical Exam Combo', price: '239.99', turnaround: 'Complete DOT Clearance' },
      { value: '5-panel-return-to-duty', name: '5 Panel Return to Duty (RTD) Test', price: '99.99', turnaround: 'Directly Observed / 24-48 hrs' },
      { value: 'dot-uscg-drug-test', name: 'DOT USCG Merchant Mariner Drug Test', price: '99.99', turnaround: 'Coast Guard Form 719P' },
      { value: '1-year-enrollment', name: '1-Year DOT Consortium Enrollment', price: '99.99', turnaround: 'Instant Certificate' },
      { value: '1-year-consortium-membership-dot-drug-test', name: '1-Year Consortium + DOT Drug Test', price: '249.99', turnaround: 'Instant Certificate & Pass' },
      { value: 'fmcsa-clearinghouse-accucheck', name: 'FMCSA Clearinghouse Services', price: '199.99', turnaround: 'Full Query & Violation Support' },
    ],
    hair: [
      { value: 'hair-follicle-5-panel', name: 'Hair Follicle 5-Panel (90-Day History)', price: '169.99', turnaround: '2-3 Business Days' },
      { value: 'hair-follicle-10-panel', name: 'Hair Follicle 10-Panel Comprehensive', price: '249.99', turnaround: '2-3 Business Days' },
      { value: 'hair-follicle-etg', name: 'Hair Follicle Alcohol EtG (3-Month History)', price: '199.99', turnaround: '3-5 Business Days' },
    ],
    alcohol: [
      { value: 'dot-breath-alcohol', name: 'Breath Alcohol Test (BAT / EBT)', price: '89.99', turnaround: 'Instant Reading' },
      { value: 'etg-urine-alcohol', name: '80-Hour EtG Urine Alcohol Test', price: '89.99', turnaround: '24-48 hours' },
      { value: 'hair-follicle-etg', name: 'Hair Follicle Alcohol EtG (90-Day)', price: '199.99', turnaround: '3-5 Business Days' },
    ],
    oral: [
      { value: 'oral-fluid-6-panel', name: 'Oral Fluid 6-Panel Saliva Drug Test', price: '109.99', turnaround: '24-48 hours' },
      { value: 'oral-fluid-10-panel', name: 'Oral Fluid 10-Panel Saliva Drug Test', price: '129.99', turnaround: '24-48 hours' },
    ],
    occupational: [
      { value: 'fit-for-duty', name: 'Fit-For-Duty Medical Examination', price: '179.99', turnaround: 'Comprehensive Report' },
      { value: 'tb-skin-test', name: 'TB Skin Test (Mantoux PPD)', price: '79.99', turnaround: '48-72 Hour Read' },
      { value: 'respirator-clearance', name: 'OSHA Respirator Clearance Exam', price: '99.99', turnaround: 'Same-Day Clearance' },
    ],
    clinical: [
      { value: 'comprehensive-health-profile', name: 'Comprehensive Health Profile (CBC & CMP)', price: '99.99', turnaround: '24-48 hours' },
      { value: 'heavy-metals-blood-panel', name: 'Heavy Metals Comprehensive Blood Panel', price: '149.99', turnaround: '2-3 Business Days' },
      { value: 'hepatitis-b-c-panel', name: 'Hepatitis B & C Antibody Blood Panel', price: '89.99', turnaround: '24-48 hours' },
    ],
    dna: [
      { value: 'legal-paternity-dna-test', name: 'Legal Paternity DNA Test (Court Admissible)', price: '289.99', turnaround: '2-3 Business Days' },
      { value: 'non-invasive-prenatal-paternity-nipp', name: 'Non-Invasive Prenatal Paternity (NIPP)', price: '999.00', turnaround: '5-7 Business Days' },
      { value: 'informational-paternity-kit', name: 'Informational At-Home Paternity Kit', price: '179.99', turnaround: '3-5 Business Days' },
    ]
  };

  window.handleEstimatorReasonChange = function (reason) {
    // Preserves selected reason without overwriting testing method
  };

  window.handleEstimatorAgencyChange = function (agency) {
    const specimenSelect = document.getElementById('estSpecimen');
    if (!specimenSelect) return;

    if (agency === 'USCG') {
      const uscgOpt = Array.from(specimenSelect.options).find(o => o.value === 'dot-uscg-drug-test');
      if (uscgOpt) {
        specimenSelect.value = 'dot-uscg-drug-test';
        updateEstimatorDisplay();
      }
    } else if (specimenSelect.value === 'dot-uscg-drug-test') {
      specimenSelect.value = '5-panel-dot';
      updateEstimatorDisplay();
    }
  };

  window.handleEstimatorMethodChange = function (method) {
    const specimenSelect = document.getElementById('estSpecimen');
    const dotAgencyGroup = document.getElementById('estDotAgencyGroup');

    if (method === 'dot') {
      if (dotAgencyGroup) dotAgencyGroup.style.display = 'block';
    } else {
      if (dotAgencyGroup) dotAgencyGroup.style.display = 'none';
    }

    if (!specimenSelect) return;

    const panels = estimatorMethodPanels[method] || estimatorMethodPanels['urine'];
    specimenSelect.innerHTML = '';

    panels.forEach(p => {
      const opt = document.createElement('option');
      opt.value = p.value;
      opt.setAttribute('data-name', p.name);
      opt.setAttribute('data-price', p.price);
      opt.setAttribute('data-turnaround', p.turnaround);
      opt.textContent = p.name;
      specimenSelect.appendChild(opt);
    });

    updateEstimatorDisplay();
  };

  window.updateEstimatorDisplay = function () {
    const specimenSelect = document.getElementById('estSpecimen');
    const priceDisplay = document.getElementById('estPriceVal');
    const nameDisplay = document.getElementById('estPanelName');
    const turnaroundDisplay = document.getElementById('estTurnaround');

    if (!specimenSelect) return;
    const selectedOpt = specimenSelect.options[specimenSelect.selectedIndex];
    if (!selectedOpt) return;

    const price = selectedOpt.getAttribute('data-price') || '89.99';
    const name = selectedOpt.getAttribute('data-name') || selectedOpt.text;
    const turnaround = selectedOpt.getAttribute('data-turnaround') || '24-48 hours';

    if (priceDisplay) priceDisplay.textContent = '$' + Number(price).toFixed(2);
    if (nameDisplay) nameDisplay.textContent = name;
    if (turnaroundDisplay) {
      turnaroundDisplay.innerHTML = 'Includes: Laboratory Analysis, MRO/Physician Verified, Results ' + turnaround;
    }
  };

  window.handleEstimatorOrder = function () {
    const specimenSelect = document.getElementById('estSpecimen');
    const reasonSelect = document.getElementById('estReason');
    const dotAgencySelect = document.getElementById('estDotAgency');

    const selectedOpt = specimenSelect ? specimenSelect.options[specimenSelect.selectedIndex] : null;
    const panelKey = specimenSelect?.value || '5-panel-non-dot';
    const panelName = selectedOpt ? (selectedOpt.getAttribute('data-name') || selectedOpt.text) : '5 Panel Non-DOT Urine Test';
    const panelPrice = selectedOpt ? (selectedOpt.getAttribute('data-price') || '89.99') : '89.99';
    const reason = reasonSelect ? reasonSelect.value : 'Pre-Employment';
    const methodSelect = document.getElementById('estMethod');
    const isDot = (methodSelect?.value === 'dot' || panelKey.includes('dot'));
    const dotAgency = (isDot && dotAgencySelect) ? dotAgencySelect.value : 'FMCSA';

    openOrderModal(panelKey, panelName, panelPrice);

    // Sync modal reason & agency
    const modalReason = document.getElementById('testingReason');
    if (modalReason) {
      modalReason.value = reason;
      if (typeof handleModalReasonChange === 'function') {
        handleModalReasonChange(reason);
      }
    }
    const modalDotAgency = document.getElementById('modalDotAgency');
    const modalDotGroup = document.getElementById('modalDotAgencyGroup');
    if (modalDotAgency && isDot) {
      if (modalDotGroup) modalDotGroup.style.display = 'block';
      modalDotAgency.value = dotAgency;
      if (typeof handleModalDotAgencyChange === 'function') {
        handleModalDotAgencyChange(dotAgency);
      }
    }
  };

  if (estSpecimen) {
    estSpecimen.addEventListener('change', updateEstimatorDisplay);
  }
});

// Modal Dialog Helpers
function openOrderModal(productId, productName, price) {
  const modal = document.getElementById('orderModal');
  if (!modal) return;
  const nameEl = document.getElementById('modalProductName');
  const priceEl = document.getElementById('modalProductPrice');
  const testInput = document.getElementById('modalInputTestName');
  const prodIdInput = document.getElementById('modalInputProductId');

  if (nameEl) nameEl.textContent = productName || 'Drug Test Registration';
  if (priceEl) priceEl.textContent = price ? '$' + Number(price).toFixed(2) : '$89.99';
  if (testInput) testInput.value = productName;
  if (prodIdInput && productId) prodIdInput.value = productId;

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

function handleModalReasonChange(reason) {
  const dotAgencyGroup = document.getElementById('modalDotAgencyGroup');
  const nonDotGroup = document.getElementById('modalNonDotIdGroup');
  const fmcsaGroup = document.getElementById('modalFmcsaGroup');
  const dotOtherGroup = document.getElementById('modalDotOtherGroup');
  const agencySelect = document.getElementById('modalDotAgency');
  const currentAgency = agencySelect ? agencySelect.value : 'FMCSA';

  if (reason === 'dot') {
    if (dotAgencyGroup) dotAgencyGroup.style.display = 'block';
    if (nonDotGroup) nonDotGroup.style.display = 'none';
    handleModalDotAgencyChange(currentAgency);
  } else {
    if (dotAgencyGroup) dotAgencyGroup.style.display = 'none';
    if (nonDotGroup) nonDotGroup.style.display = 'block';
    if (fmcsaGroup) fmcsaGroup.style.display = 'none';
    if (dotOtherGroup) dotOtherGroup.style.display = 'none';
  }
}

function handleModalDotAgencyChange(agency) {
  const fmcsaGroup = document.getElementById('modalFmcsaGroup');
  const dotOtherGroup = document.getElementById('modalDotOtherGroup');
  const nonDotGroup = document.getElementById('modalNonDotIdGroup');

  if (nonDotGroup) nonDotGroup.style.display = 'none';

  if (agency === 'FMCSA') {
    if (fmcsaGroup) fmcsaGroup.style.display = 'grid';
    if (dotOtherGroup) dotOtherGroup.style.display = 'none';
  } else {
    if (fmcsaGroup) fmcsaGroup.style.display = 'none';
    if (dotOtherGroup) dotOtherGroup.style.display = 'block';
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
            <span style="font-size:12px; margin-top:6px; display:inline-block;">Call our toxicologists at <a href="tel:18009854339" style="color:#C1121F; font-weight:700;">(800)-985-4339</a> to customize a custom substance panel.</span>
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
      resultsContainer.innerHTML = '<div class="search-empty-state" style="color:#C1121F;">Error searching tests. Please try again or call (800)-985-4339.</div>';
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
          const profileLink = loc.profile_url || `/location/${loc.id}`;
          const checkoutLink = loc.checkout_url || `/checkout?location_id=${loc.id}`;
          const directionsLink = loc.directions_url || `https://maps.google.com/?q=${encodeURIComponent(loc.address || loc.address1 + ', ' + loc.city + ', ' + loc.state)}`;
          const addressText = loc.address || `${loc.address1 || ''}, ${loc.city}, ${loc.state} ${loc.zip}`;

          html += `
            <div class="global-zip-item" style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; padding:14px; border-bottom:1px solid #E2E8F0;">
              <div>
                <div class="global-zip-item-title" style="font-size:14.5px; font-weight:700; color:#0B2545;">
                  <a href="${profileLink}" style="color:#0B2545; text-decoration:none;">${idx + 1}. ${loc.name}</a>
                </div>
                <div class="global-zip-item-address" style="font-size:13px; color:#475569; margin:2px 0;">${addressText}</div>
                <div class="global-zip-item-hours" style="font-size:12px; color:#64748B;">● ${loc.hours || 'Mon-Fri 8:00 AM - 5:00 PM'}</div>
                <div style="margin-top:6px; display:flex; gap:10px; font-size:12px;">
                  <a href="${profileLink}" style="color:#0B2545; font-weight:700; text-decoration:underline;">View Facility Profile &rarr;</a>
                  <a href="${directionsLink}" target="_blank" rel="noopener" style="color:#64748B; font-weight:600; text-decoration:none;">📍 Directions</a>
                </div>
              </div>
              <a href="${checkoutLink}" class="btn btn-primary btn-sm" style="white-space:nowrap; align-self:center;">
                Schedule Here &rarr;
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
      resultsContainer.innerHTML = '<div style="text-align:center; padding:16px; color:#C1121F;">Unable to lookup locations. Please call (800)-985-4339 for immediate dispatch.</div>';
    });
}

