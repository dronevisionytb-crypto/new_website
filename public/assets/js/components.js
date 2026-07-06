/**
 * Drone Vision - Reusable Components
 * Modern UI Components for Dashboard
 */

// Modal Component
class Modal {
  constructor(id) {
    this.modal = document.getElementById(id);
    this.setupListeners();
  }

  setupListeners() {
    if (!this.modal) return;
    
    const closeBtn = this.modal.querySelector('.modal-close');
    if (closeBtn) {
      closeBtn.addEventListener('click', () => this.close());
    }

    this.modal.addEventListener('click', (e) => {
      if (e.target === this.modal) this.close();
    });
  }

  open() {
    if (this.modal) {
      this.modal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  }

  close() {
    if (this.modal) {
      this.modal.classList.remove('active');
      document.body.style.overflow = '';
    }
  }

  toggle() {
    if (this.modal?.classList.contains('active')) {
      this.close();
    } else {
      this.open();
    }
  }
}

// Alert Component
class Alert {
  static show(message, type = 'info', duration = 5000) {
    const alertId = 'alert-' + Date.now();
    const container = document.querySelector('.content') || document.body;
    
    const alert = document.createElement('div');
    alert.id = alertId;
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `<strong>${this.getTitle(type)}:</strong> ${message}`;
    
    container.insertBefore(alert, container.firstChild);

    if (duration > 0) {
      setTimeout(() => {
        alert.remove();
      }, duration);
    }

    return alertId;
  }

  static remove(id) {
    const alert = document.getElementById(id);
    if (alert) alert.remove();
  }

  static getTitle(type) {
    const titles = {
      'success': 'Succès',
      'error': 'Erreur',
      'warning': 'Attention',
      'info': 'Information'
    };
    return titles[type] || 'Message';
  }
}

// Form Validation
class FormValidator {
  constructor(form) {
    this.form = form;
    this.errors = {};
  }

  addRule(fieldName, rules) {
    const field = this.form.querySelector(`[name="${fieldName}"]`);
    if (!field) return;

    field.addEventListener('blur', () => this.validateField(fieldName, rules));
  }

  validateField(fieldName, rules) {
    const field = this.form.querySelector(`[name="${fieldName}"]`);
    if (!field) return true;

    const value = field.value.trim();
    this.errors[fieldName] = [];

    for (const rule of rules) {
      if (!this.checkRule(rule, value)) {
        this.errors[fieldName].push(rule.message);
      }
    }

    this.updateFieldUI(field, this.errors[fieldName].length === 0);
    return this.errors[fieldName].length === 0;
  }

  checkRule(rule, value) {
    if (rule.type === 'required') return value.length > 0;
    if (rule.type === 'email') return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    if (rule.type === 'minLength') return value.length >= rule.value;
    if (rule.type === 'maxLength') return value.length <= rule.value;
    if (rule.type === 'pattern') return rule.value.test(value);
    return true;
  }

  updateFieldUI(field, isValid) {
    const group = field.closest('.form-group');
    if (!group) return;

    if (isValid) {
      field.style.borderColor = '';
      const error = group.querySelector('.field-error');
      if (error) error.remove();
    } else {
      field.style.borderColor = 'var(--danger)';
      this.showFieldError(field, this.errors[field.name]);
    }
  }

  showFieldError(field, errors) {
    const group = field.closest('.form-group');
    const existing = group.querySelector('.field-error');
    if (existing) existing.remove();

    if (errors.length > 0) {
      const errorEl = document.createElement('div');
      errorEl.className = 'field-error';
      errorEl.style.cssText = 'color: var(--danger); font-size: 12px; margin-top: 4px;';
      errorEl.textContent = errors[0];
      group.appendChild(errorEl);
    }
  }

  validate() {
    const fields = this.form.querySelectorAll('input, select, textarea');
    let isValid = true;

    fields.forEach(field => {
      const rules = field.dataset.rules ? JSON.parse(field.dataset.rules) : [];
      if (!this.validateField(field.name, rules)) {
        isValid = false;
      }
    });

    return isValid;
  }
}

// Table Utilities
class TableHelper {
  static makeFilterable(tableSelector) {
    const tables = document.querySelectorAll(tableSelector);
    
    tables.forEach(table => {
      const tbody = table.querySelector('tbody');
      if (!tbody) return;

      const rows = Array.from(tbody.querySelectorAll('tr'));

      const container = table.closest('.table-container') || table.parentElement;
      const searchInput = document.createElement('input');
      searchInput.type = 'text';
      searchInput.placeholder = 'Rechercher...';
      searchInput.className = 'form-group';
      searchInput.style.cssText = 'padding: 12px 14px; border: 1px solid var(--gray-200); border-radius: var(--radius-md); margin-bottom: 16px; width: 100%;';
      
      container.insertBefore(searchInput, table);

      searchInput.addEventListener('keyup', (e) => {
        const filter = e.target.value.toLowerCase();
        rows.forEach(row => {
          const text = row.textContent.toLowerCase();
          row.style.display = text.includes(filter) ? '' : 'none';
        });
      });
    });
  }

  static makeSortable(tableSelector) {
    const tables = document.querySelectorAll(tableSelector);
    
    tables.forEach(table => {
      const headers = table.querySelectorAll('th');
      headers.forEach((header, index) => {
        header.style.cursor = 'pointer';
        header.style.userSelect = 'none';
        header.addEventListener('click', () => this.sortTable(table, index));
      });
    });
  }

  static sortTable(table, columnIndex) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    rows.sort((a, b) => {
      const aCell = a.children[columnIndex];
      const bCell = b.children[columnIndex];
      
      const aValue = aCell.textContent.trim();
      const bValue = bCell.textContent.trim();

      return aValue.localeCompare(bValue, undefined, { numeric: true });
    });

    rows.forEach(row => tbody.appendChild(row));
  }
}

// Loading State Manager
class LoadingState {
  static show(element) {
    const loader = document.createElement('div');
    loader.className = 'loading';
    loader.innerHTML = `<div class="spinner"></div> <span>Chargement...</span>`;
    
    element.innerHTML = '';
    element.appendChild(loader);
  }

  static hide(element) {
    element.innerHTML = '';
  }
}

// Format Utilities
const Format = {
  currency(value, symbol = '€') {
    return new Intl.NumberFormat('fr-FR', {
      style: 'currency',
      currency: 'EUR'
    }).format(value);
  },

  date(dateString, locale = 'fr-FR') {
    return new Date(dateString).toLocaleDateString(locale);
  },

  datetime(dateString, locale = 'fr-FR') {
    return new Date(dateString).toLocaleString(locale);
  },

  time(dateString, locale = 'fr-FR') {
    return new Date(dateString).toLocaleTimeString(locale);
  },

  percentage(value, decimals = 1) {
    return (value * 100).toFixed(decimals) + '%';
  }
};

// Document Ready
document.addEventListener('DOMContentLoaded', function() {
  // Initialize tooltips if any
  const tooltips = document.querySelectorAll('[data-tooltip]');
  tooltips.forEach(element => {
    element.title = element.dataset.tooltip;
  });

  // Add active class to nav icons
  const navIcons = document.querySelectorAll('.nav-icon');
  navIcons.forEach(icon => {
    icon.style.width = '20px';
    icon.style.height = '20px';
  });
});

// Export for use
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { Modal, Alert, FormValidator, TableHelper, LoadingState, Format };
}