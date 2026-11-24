(() => {
  'use strict';

  // 1. Popover API polyfill (loaded strictly when native support is missing)
  if (!Object.hasOwn(HTMLElement.prototype, 'popover')) {
    import('https://unpkg.com/@oddbird/popover-polyfill@latest/dist/popover.min.js').catch(() => {});
  }

  // 2. Responsive Navbar layout measurement (ResizeObserver -> .is-wide)
  const header = document.getElementById('site-header');
  const inner = header?.querySelector('.header-inner');
  const menu = document.getElementById('site-menu');
  const menuBtn = header?.querySelector('.menu-button');

  if (header && inner && menu) {
    let lastWidth = header.getBoundingClientRect().width;

    const syncNavbarLayout = () => {
      const wasWide = header.classList.contains('is-wide');
      const wasOpen = !wasWide && menu.matches(':popover-open, .\\:popover-open');

      header.classList.add('is-measuring');
      header.classList.add('is-wide');
      menu.removeAttribute('popover');

      const fits = inner.scrollWidth <= inner.clientWidth + 1;

      if (fits) {
        header.classList.add('is-wide');
        menu.removeAttribute('popover');
      } else {
        header.classList.remove('is-wide');
        menu.setAttribute('popover', 'auto');
        if (wasOpen && typeof menu.showPopover === 'function') {
          try {
            menu.showPopover();
          } catch (_) {
            // Ignore if polyfill is still initializing
          }
        }
      }

      requestAnimationFrame(() => {
        header.classList.remove('is-measuring');
      });
    };

    syncNavbarLayout();

    if (typeof ResizeObserver !== 'undefined') {
      const ro = new ResizeObserver((entries) => {
        const currentWidth = entries[0]?.contentRect?.width ?? header.getBoundingClientRect().width;
        const isWideNow = header.classList.contains('is-wide');
        if (isWideNow || currentWidth > lastWidth) {
          syncNavbarLayout();
        }
        lastWidth = currentWidth;
      });
      ro.observe(header);
      ro.observe(menu);
    } else {
      window.addEventListener('resize', syncNavbarLayout);
    }

    // Close mobile popover cleanly when an anchor link inside is clicked
    menu.addEventListener('click', (e) => {
      if (e.target.closest('a') && !header.classList.contains('is-wide') && typeof menu.hidePopover === 'function') {
        try {
          menu.hidePopover();
        } catch (_) {}
      }
    });
  }

  // 3. After-interaction validation ARIA sync + :user-invalid fallback
  const linkError = (el, shown) => {
    const errorId = el.dataset.error;
    if (!errorId) return;

    const ids = (el.getAttribute('aria-describedby') || '')
      .split(/\s+/)
      .filter((id) => id && id !== errorId);

    if (shown) ids.push(errorId);
    if (ids.length) el.setAttribute('aria-describedby', ids.join(' '));
    else el.removeAttribute('aria-describedby');
  };

  const announcer = document.createElement('div');
  announcer.setAttribute('aria-live', 'polite');
  announcer.classList.add('visually-hidden');
  document.body.append(announcer);

  let announceTimer;
  let announcedField;

  const spokenText = (node) => {
    const copy = node.cloneNode(true);
    copy.querySelectorAll('[aria-hidden="true"]').forEach((n) => n.remove());
    copy.querySelectorAll('[role="img"][aria-label]').forEach((n) => {
      n.replaceWith(`${n.getAttribute('aria-label')}: `);
    });
    return copy.textContent.replace(/\s+/g, ' ').trim();
  };

  const announceError = (el) => {
    const error = document.getElementById(el.dataset.error);
    if (!error) return;

    const label = el.labels?.[0] ? `${spokenText(el.labels[0])}: ` : '';
    clearTimeout(announceTimer);
    announcer.textContent = '';
    announcedField = el;
    announceTimer = setTimeout(() => {
      announcer.textContent = label + spokenText(error);
    }, 500);
  };

  const supportsUserInvalid = typeof CSS !== 'undefined' && CSS.supports('selector(:user-invalid)');
  const dirtyState = new WeakMap();
  const flagged = new WeakSet();
  const announced = new WeakSet();

  const syncAria = (el, announce = false) => {
    if (!el.matches?.('input, select, textarea') || el.type === 'hidden') return;

    const invalid = supportsUserInvalid
      ? el.matches(':user-invalid')
      : el.classList.contains('user-invalid-fallback');

    if (invalid) {
      if (announce && !announced.has(el)) {
        announceError(el);
        announced.add(el);
      }
      el.setAttribute('aria-invalid', 'true');
      linkError(el, true);
      flagged.add(el);
    } else if (flagged.has(el) || el.getAttribute('aria-invalid') !== 'true') {
      el.setAttribute('aria-invalid', 'false');
      linkError(el, false);
      flagged.delete(el);
      announced.delete(el);
      if (announcedField === el) {
        clearTimeout(announceTimer);
        announcer.textContent = '';
      }
    }
  };

  if (!supportsUserInvalid) {
    const updateFallback = (input) => {
      const isValid = input.validity.valid;
      input.classList.toggle('user-invalid-fallback', !isValid);
      input.classList.toggle('user-valid-fallback', isValid);
    };

    const handleFallback = (event) => {
      const input = event.target;
      if (event.type === 'reset') {
        for (const control of input.elements || []) {
          dirtyState.delete(control);
          control.classList.remove('user-invalid-fallback', 'user-valid-fallback');
        }
        return;
      }

      if (!input.checkValidity) return;

      if (event.type === 'invalid') {
        dirtyState.set(input, { hasInteracted: true, hasBlurred: true });
        updateFallback(input);
        return;
      }

      if (event.type === 'input' || event.type === 'change') {
        const state = dirtyState.get(input) || { hasInteracted: false, hasBlurred: false };
        state.hasInteracted = true;
        dirtyState.set(input, state);
        if (state.hasBlurred) updateFallback(input);
      } else if (event.type === 'blur') {
        const state = dirtyState.get(input) || { hasInteracted: false, hasBlurred: false };
        state.hasBlurred = true;
        dirtyState.set(input, state);
        if (state.hasInteracted) updateFallback(input);
      }
    };

    document.addEventListener('blur', handleFallback, true);
    document.addEventListener('input', handleFallback);
    document.addEventListener('change', handleFallback);
    document.addEventListener('invalid', handleFallback, true);
    document.addEventListener('reset', handleFallback, true);
  }

  document.querySelectorAll('input, select, textarea').forEach((el) => syncAria(el));

  document.addEventListener('blur', (e) => syncAria(e.target, true), true);
  document.addEventListener('input', (e) => {
    if (e.target.hasAttribute('aria-invalid')) syncAria(e.target);
  });
  document.addEventListener('change', (e) => syncAria(e.target, true), true);
  document.addEventListener('invalid', (e) => {
    announced.add(e.target);
    syncAria(e.target);
  }, true);
  document.addEventListener('reset', (e) => {
    setTimeout(() => [...(e.target.elements || [])].forEach((el) => syncAria(el)));
  }, true);

  // 4. Show / Hide Password toggle
  document.querySelectorAll('[data-toggle-password]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const targetId = btn.getAttribute('data-toggle-password');
      const input = document.getElementById(targetId);
      if (!input) return;

      const showing = input.type === 'text';
      input.type = showing ? 'password' : 'text';
      btn.setAttribute('aria-pressed', showing ? 'false' : 'true');
      btn.textContent = showing ? 'Lihat' : 'Tutup';
    });
  });

  // 5. Native <dialog> fallback light dismiss when closedby="any" is unsupported
  if (!('closedBy' in HTMLDialogElement.prototype)) {
    const outside = (e, dialog) => {
      const r = dialog.getBoundingClientRect();
      return e.clientX < r.left || e.clientX > r.right || e.clientY < r.top || e.clientY > r.bottom;
    };

    for (const dialog of document.querySelectorAll('dialog[closedby="any"]')) {
      let pressedOutside = false;
      dialog.addEventListener('pointerdown', (e) => {
        pressedOutside = outside(e, dialog);
      });
      dialog.addEventListener('pointerup', (e) => {
        if (pressedOutside && outside(e, dialog)) dialog.close();
      });
    }
  }

  // 6. Delete Confirmation <dialog> binding
  const deleteDialog = document.getElementById('delete-court-dialog');
  const deleteForm = document.getElementById('delete-court-form');
  const deleteNameSpan = document.getElementById('delete-court-name');

  if (deleteDialog && deleteForm) {
    document.querySelectorAll('[data-delete-court-url]').forEach((btn) => {
      btn.addEventListener('click', () => {
        deleteForm.action = btn.getAttribute('data-delete-court-url');
        if (deleteNameSpan) {
          deleteNameSpan.textContent = btn.getAttribute('data-delete-court-name') || 'lapangan ini';
        }
        deleteDialog.showModal();
      });
    });

    deleteDialog.addEventListener('close', () => {
      deleteDialog.returnValue = '';
    });
  }
})();
