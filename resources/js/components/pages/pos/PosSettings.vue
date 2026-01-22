<template>
    <div class="pos-settings-page">
        <div class="page-header">
            <h2><i class="fas fa-cog"></i> POS Settings</h2>
            <router-link to="/dashboard/pos" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Back to POS
            </router-link>
        </div>

        <div class="settings-container" v-if="!loading">
            <!-- Tax Settings -->
            <div class="settings-card">
                <h4><i class="fas fa-percent"></i> Tax Settings</h4>
                <div class="form-group">
                    <label>Tax Rate (%)</label>
                    <input
                        type="number"
                        v-model.number="settings.tax_rate"
                        class="form-control"
                        min="0"
                        max="100"
                        step="0.01"
                    />
                    <small class="text-muted">Applied to all sales. Set to 0 for no tax.</small>
                </div>
            </div>

            <!-- Inventory Settings -->
            <div class="settings-card">
                <h4><i class="fas fa-boxes"></i> Inventory Settings</h4>
                <div class="form-group">
                    <label>Costing Method</label>
                    <select v-model="settings.costing_method" class="form-control">
                        <option value="average">Average Cost</option>
                        <option value="fifo">FIFO (First In, First Out)</option>
                    </select>
                    <small class="text-muted">Method used to calculate cost of goods sold.</small>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" v-model="settings.allow_negative_stock" />
                        <span>Allow Negative Stock</span>
                    </label>
                    <small class="text-muted">Allow sales even when stock is insufficient.</small>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" v-model="settings.show_stock_warning" />
                        <span>Show Low Stock Warning</span>
                    </label>
                    <small class="text-muted">Display warning when product stock is low.</small>
                </div>
            </div>

            <!-- Receipt Settings -->
            <div class="settings-card">
                <h4><i class="fas fa-receipt"></i> Receipt Settings</h4>
                <div class="form-group">
                    <label>Receipt Header</label>
                    <input
                        type="text"
                        v-model="settings.receipt_header"
                        class="form-control"
                        placeholder="Store name or custom header"
                    />
                </div>
                <div class="form-group">
                    <label>Receipt Footer</label>
                    <input
                        type="text"
                        v-model="settings.receipt_footer"
                        class="form-control"
                        placeholder="Thank you message"
                    />
                </div>
                <div class="form-group">
                    <label>Receipt Size</label>
                    <select v-model="settings.receipt_size" class="form-control">
                        <option value="58mm">58mm (Small)</option>
                        <option value="80mm">80mm (Standard)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" v-model="settings.print_receipt_auto" />
                        <span>Auto-Print Receipt</span>
                    </label>
                    <small class="text-muted">Automatically print receipt after sale completion.</small>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="settings-card">
                <h4><i class="fas fa-credit-card"></i> Payment Methods</h4>
                <div class="payment-methods-grid">
                    <label class="payment-method-option" v-for="method in allPaymentMethods" :key="method.value">
                        <input
                            type="checkbox"
                            :value="method.value"
                            v-model="settings.payment_methods"
                        />
                        <span class="method-box">
                            <i :class="method.icon"></i>
                            <span>{{ method.label }}</span>
                        </span>
                    </label>
                </div>
            </div>

            <!-- General Settings -->
            <div class="settings-card">
                <h4><i class="fas fa-sliders-h"></i> General Settings</h4>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" v-model="settings.require_customer" />
                        <span>Require Customer Selection</span>
                    </label>
                    <small class="text-muted">Customer must be selected before completing sale.</small>
                </div>
            </div>

            <!-- Keyboard Shortcuts -->
            <div class="settings-card">
                <h4><i class="fas fa-keyboard"></i> Keyboard Shortcuts</h4>
                <div class="shortcuts-table">
                    <div class="shortcut-row" v-for="(action, key) in defaultShortcuts" :key="key">
                        <span class="shortcut-key">{{ key }}</span>
                        <span class="shortcut-action">{{ formatAction(action) }}</span>
                    </div>
                </div>
                <small class="text-muted">Keyboard shortcuts cannot be customized at this time.</small>
            </div>

            <!-- Actions -->
            <div class="settings-actions">
                <button class="btn btn-secondary" @click="resetSettings" :disabled="saving">
                    <i class="fas fa-undo"></i> Reset to Defaults
                </button>
                <button class="btn btn-primary" @click="saveSettings" :disabled="saving">
                    <i class="fas fa-save"></i> {{ saving ? 'Saving...' : 'Save Settings' }}
                </button>
            </div>
        </div>

        <div v-else class="loading-state">
            <i class="fas fa-spinner fa-spin"></i> Loading settings...
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'PosSettings',
    data() {
        return {
            loading: true,
            saving: false,
            settings: {
                tax_rate: 0,
                costing_method: 'average',
                allow_negative_stock: false,
                show_stock_warning: true,
                receipt_header: '',
                receipt_footer: 'Thank you for your purchase!',
                print_receipt_auto: true,
                receipt_size: '80mm',
                require_customer: false,
                payment_methods: ['cash', 'card', 'wallet', 'bank_transfer'],
                keyboard_shortcuts: {},
            },
            allPaymentMethods: [
                { value: 'cash', label: 'Cash', icon: 'fas fa-money-bill-wave' },
                { value: 'card', label: 'Card', icon: 'fas fa-credit-card' },
                { value: 'wallet', label: 'Wallet', icon: 'fas fa-wallet' },
                { value: 'bank_transfer', label: 'Bank Transfer', icon: 'fas fa-university' },
            ],
            defaultShortcuts: {
                'F1': 'focus_search',
                'F2': 'new_cart',
                'F3': 'switch_cart',
                'F4': 'park_sale',
                'F5': 'view_parked',
                'F8': 'apply_discount',
                'F9': 'select_customer',
                'F10': 'open_payment',
                'F12': 'quick_cash',
                'Esc': 'cancel',
                'Delete': 'remove_item',
            },
        };
    },
    methods: {
        async loadSettings() {
            try {
                const response = await axios.get('/dashboard/api/pos/settings');
                const data = response.data.data;

                this.settings = {
                    tax_rate: parseFloat(data.tax_rate) || 0,
                    costing_method: data.costing_method || 'average',
                    allow_negative_stock: data.allow_negative_stock || false,
                    show_stock_warning: data.show_stock_warning !== false,
                    receipt_header: data.receipt_header || '',
                    receipt_footer: data.receipt_footer || 'Thank you for your purchase!',
                    print_receipt_auto: data.print_receipt_auto !== false,
                    receipt_size: data.receipt_size || '80mm',
                    require_customer: data.require_customer || false,
                    payment_methods: data.payment_methods || ['cash', 'card', 'wallet', 'bank_transfer'],
                    keyboard_shortcuts: data.keyboard_shortcuts || {},
                };
            } catch (error) {
                console.error('Failed to load settings:', error);
                this.$toast?.error('Failed to load settings');
            } finally {
                this.loading = false;
            }
        },

        async saveSettings() {
            this.saving = true;
            try {
                await axios.put('/dashboard/api/pos/settings', this.settings);
                this.$toast?.success('Settings saved successfully');
            } catch (error) {
                console.error('Failed to save settings:', error);
                this.$toast?.error('Failed to save settings');
            } finally {
                this.saving = false;
            }
        },

        async resetSettings() {
            if (!confirm('Reset all settings to defaults?')) return;

            this.saving = true;
            try {
                const response = await axios.post('/dashboard/api/pos/settings/reset');
                this.settings = response.data.data;
                this.$toast?.success('Settings reset to defaults');
            } catch (error) {
                console.error('Failed to reset settings:', error);
                this.$toast?.error('Failed to reset settings');
            } finally {
                this.saving = false;
            }
        },

        formatAction(action) {
            const labels = {
                focus_search: 'Focus product search',
                new_cart: 'Create new cart',
                switch_cart: 'Switch to next cart',
                park_sale: 'Park current sale',
                view_parked: 'View parked sales',
                apply_discount: 'Apply discount',
                select_customer: 'Select customer',
                open_payment: 'Open payment modal',
                quick_cash: 'Quick cash payment',
                cancel: 'Cancel / Close',
                remove_item: 'Remove selected item',
            };
            return labels[action] || action;
        },
    },
    mounted() {
        this.loadSettings();
    },
};
</script>

<style scoped>
.pos-settings-page {
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-header h2 {
    margin: 0;
}

.settings-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.settings-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.settings-card h4 {
    margin: 0 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #e0e0e0;
    color: #333;
}

.settings-card h4 i {
    margin-right: 10px;
    color: #2196f3;
}

.form-group {
    margin-bottom: 20px;
}

.form-group:last-child {
    margin-bottom: 0;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
}

.form-control:focus {
    outline: none;
    border-color: #2196f3;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-weight: normal !important;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
    flex-shrink: 0;
}

.text-muted {
    display: block;
    margin-top: 5px;
    font-size: 12px;
    color: #888;
}

/* Payment Methods Grid */
.payment-methods-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 10px;
}

.payment-method-option {
    cursor: pointer;
}

.payment-method-option input {
    display: none;
}

.method-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    transition: all 0.2s;
}

.payment-method-option input:checked + .method-box {
    border-color: #2196f3;
    background: #e3f2fd;
}

.method-box i {
    font-size: 24px;
    margin-bottom: 8px;
    color: #666;
}

.payment-method-option input:checked + .method-box i {
    color: #2196f3;
}

/* Shortcuts Table */
.shortcuts-table {
    display: grid;
    gap: 10px;
}

.shortcut-row {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 10px;
    background: #f5f5f5;
    border-radius: 8px;
}

.shortcut-key {
    display: inline-block;
    padding: 5px 12px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-family: monospace;
    font-weight: 600;
    min-width: 60px;
    text-align: center;
}

.shortcut-action {
    color: #666;
}

/* Actions */
.settings-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 20px;
    border-top: 1px solid #e0e0e0;
}

/* Loading */
.loading-state {
    text-align: center;
    padding: 60px;
    color: #888;
}

.loading-state i {
    font-size: 32px;
    margin-bottom: 10px;
}

/* ============================================
   MOBILE RESPONSIVE STYLES
============================================ */

/* Tablet and below */
@media (max-width: 768px) {
    .pos-settings-page {
        padding: 15px;
    }

    .page-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .page-header h2 {
        font-size: 20px;
    }

    .page-header .btn {
        width: 100%;
        justify-content: center;
        min-height: 44px;
    }

    .settings-card {
        padding: 15px;
    }

    .settings-card h4 {
        font-size: 16px;
    }

    .payment-methods-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .settings-actions {
        flex-direction: column-reverse;
    }

    .settings-actions .btn {
        width: 100%;
        min-height: 48px;
    }
}

/* Mobile phones */
@media (max-width: 480px) {
    .pos-settings-page {
        padding: 10px;
        max-width: 100%;
    }

    .page-header h2 {
        font-size: 18px;
    }

    .page-header h2 i {
        font-size: 16px;
    }

    .settings-container {
        gap: 15px;
    }

    .settings-card {
        padding: 12px;
        border-radius: 8px;
    }

    .settings-card h4 {
        font-size: 15px;
        margin-bottom: 15px;
    }

    .settings-card h4 i {
        margin-right: 8px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 14px;
    }

    .form-control {
        padding: 12px;
        font-size: 16px; /* Prevents zoom on iOS */
    }

    .checkbox-label {
        font-size: 14px;
    }

    .checkbox-label input[type="checkbox"] {
        width: 20px;
        height: 20px;
    }

    .text-muted {
        font-size: 11px;
    }

    /* Payment Methods - Single column on small screens */
    .payment-methods-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .method-box {
        flex-direction: row;
        justify-content: flex-start;
        gap: 12px;
        padding: 12px;
    }

    .method-box i {
        font-size: 20px;
        margin-bottom: 0;
    }

    /* Shortcuts - Better mobile layout */
    .shortcuts-table {
        gap: 8px;
    }

    .shortcut-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        padding: 12px;
    }

    .shortcut-key {
        padding: 6px 12px;
        font-size: 13px;
        min-width: auto;
    }

    .shortcut-action {
        font-size: 13px;
        padding-left: 0;
    }

    /* Action buttons */
    .settings-actions {
        padding-top: 15px;
        gap: 10px;
    }

    .settings-actions .btn {
        font-size: 15px;
        padding: 14px 20px;
    }
}

/* Very small phones */
@media (max-width: 360px) {
    .pos-settings-page {
        padding: 8px;
    }

    .page-header h2 {
        font-size: 16px;
    }

    .settings-card {
        padding: 10px;
    }

    .settings-card h4 {
        font-size: 14px;
    }

    .form-control {
        padding: 10px;
        font-size: 14px;
    }

    .method-box {
        padding: 10px;
    }
}

/* Landscape mode for tablets */
@media (max-width: 1024px) and (orientation: landscape) {
    .payment-methods-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}
</style>
