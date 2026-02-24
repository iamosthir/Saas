<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow-sm">

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-list"></i> قائمة المنتجات
          </h5>

          <div class="header-actions">
            <button class="btn btn-sm btn-primary" @click="printBulkLabels">
              <i class="fas fa-tags"></i> طباعة ليبل جماعي
            </button>

            <router-link :to="{name: 'products.add'}" class="btn btn-sm btn-success">
              <i class="fas fa-plus"></i> إضافة منتج
            </router-link>
          </div>
        </div>

        <div class="card-body">

          <!-- Search & Filters -->
          <div class="row mb-4">

            <div class="col-md-4 mb-2">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-search"></i>
                </span>
                <input
                  type="text"
                  class="form-control"
                  placeholder="بحث عن اسم منتج أو معرف..."
                  v-model="search"
                  @input="filterProduct"
                >
              </div>
            </div>

            <div class="col-md-3 mb-2">
              <input
                type="text"
                class="form-control"
                placeholder="بحث عن القياس..."
                v-model="measurementSearch"
                @input="filterProduct"
              >
            </div>

            <div class="col-md-3 mb-2">
              <select class="form-control" v-model="categoryFilter" @change="filterProduct">
                <option :value="null">جميع التصنيفات</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                  {{ cat.name }}
                </option>
              </select>
            </div>

            <div class="col-md-2 mb-2">
              <button class="btn btn-secondary w-100" @click="clearFilters">
                <i class="fas fa-redo"></i> إعادة تعيين
              </button>
            </div>

          </div>

          <!-- Bulk Selection -->
          <div
            class="bulk-selection-toolbar"
            v-if="paginateData.data && paginateData.data.length > 0"
          >
            <label class="selection-check">
              <input
                type="checkbox"
                :checked="areAllCurrentPageSelected"
                @change="toggleSelectAllCurrentPage"
              >
              <span>تحديد كل الصفحة</span>
            </label>

            <span class="selected-count">
              المحدد: {{ selectedProductIds.length }}
            </span>
          </div>

          <!-- Products Grid -->
          <div v-if="paginateData.data && paginateData.data.length > 0">

            <div class="row">
              <div
                class="col-md-12 col-lg-6 col-xl-4 mb-4"
                v-for="(product, i) in paginateData.data"
                :key="product.id"
              >
                <div class="product-card">

                  <!-- Select Checkbox -->
                  <div class="product-select-box">
                    <label class="selection-check">
                      <input
                        type="checkbox"
                        :checked="selectedProductIds.includes(product.id)"
                        @change="toggleProductSelection(product.id)"
                      >
                      <span>ليبل جماعي</span>
                    </label>
                  </div>

                  <!-- Image -->
                  <div class="product-image-container">
                    <img
                      v-if="product.image"
                      :src="'/uploads/products/' + product.image"
                      class="product-image"
                      :alt="product.name"
                    >
                    <img
                      v-else
                      src="/uploads/products/default.jpg"
                      class="product-image"
                      alt="لا توجد صورة"
                    >

                    <div class="product-badge" v-if="product.discount_type">
                      <i class="fas fa-tag"></i> خصم
                    </div>
                  </div>

                  <!-- Info -->
                  <div class="product-info">

                    <div class="product-header">
                      <h6 class="product-title">{{ product.name }}</h6>
                      <span class="product-id">#{{ product.id }}</span>
                    </div>

                    <div class="product-meta">
                      <span class="badge bg-secondary" v-if="product.model_name">
                        <i class="fas fa-barcode"></i> {{ product.model_name }}
                      </span>

                      <span class="badge bg-info" v-if="product.category">
                        <i class="fas fa-tag"></i> {{ product.category.name }}
                      </span>
                    </div>

                    <div class="product-description" v-if="product.description">
                      <small class="text-muted">
                        {{ product.description.substring(0, 80) }}
                        {{ product.description.length > 80 ? '...' : '' }}
                      </small>
                    </div>

                    <!-- Prices -->
                    <div class="price-summary">

                      <div class="price-row">
                        <span class="price-label">سعر الشراء:</span>
                        <span class="price-value purchase">
                          {{ formatPrice(product.purchase_price) }} IQD
                        </span>
                      </div>

                      <div class="price-row">
                        <span class="price-label">سعر البيع:</span>
                        <span class="price-value sale">
                          {{ formatPrice(product.sell_price) }} IQD
                        </span>
                      </div>

                      <div class="price-row" v-if="product.discount_type">
                        <span class="price-label">الخصم:</span>
                        <span class="price-value discount">
                          {{ product.discount_amount }}
                          {{ product.discount_type === 'percentage' ? '%' : ' IQD' }}
                        </span>
                      </div>

                    </div>

                    <!-- Stock -->
                    <div class="stock-summary">
                      <div class="stock-info">
                        <i class="fas fa-boxes"></i>
                        <span class="stock-label">إجمالي المخزون:</span>
                        <span
                          class="stock-value"
                          :class="getStockClass(product.total_stock)"
                        >
                          {{ product.total_stock }}
                        </span>
                      </div>
                    </div>

                    <!-- Variations Button -->
                    <div class="variations-toggle">
                      <button
                        class="btn btn-sm btn-outline-primary w-100"
                        @click="toggleVariations(i)"
                      >
                        <i
                          class="fas"
                          :class="product.showVariations ? 'fa-chevron-up' : 'fa-chevron-down'"
                        ></i>
                        المتغيرات ({{ product.variation ? product.variation.length : 0 }})
                      </button>
                    </div>

                    <!-- Actions -->
                    <div class="product-actions">

                      <router-link
                        :to="{name: 'product.edit', params: {productId: product.id}}"
                        class="btn btn-sm btn-warning"
                      >
                        <i class="fas fa-edit"></i> تعديل
                      </router-link>

                      <button
                        @click="printBarcode(product.id)"
                        class="btn btn-sm btn-info"
                      >
                        <i class="fas fa-barcode"></i> باركود
                      </button>

                      <button
                        @click="printSingleLabel(product.id)"
                        class="btn btn-sm btn-primary"
                      >
                        <i class="fas fa-tag"></i> ليبل
                      </button>

                      <button
                        @click="deleteProduct(product.id, i)"
                        class="btn btn-sm btn-danger"
                      >
                        <i class="fas fa-trash"></i> حذف
                      </button>

                    </div>

                  </div>
                </div>
              </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
              <pagination
                :limit="8"
                :data="paginateData"
                @pagination-change-page="getProductList"
              ></pagination>
            </div>

          </div>

          <!-- Empty State -->
          <div v-else class="empty-state text-center py-5">
            <i class="fas fa-box-open fa-3x mb-3"></i>
            <h5>لا توجد منتجات</h5>
            <p class="text-muted">ابدأ بإضافة منتج جديد</p>

            <router-link
              :to="{name: 'products.add'}"
              class="btn btn-primary"
            >
              <i class="fas fa-plus"></i> إضافة منتج
            </router-link>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      paginateData: {
        data: [],
      },
      categories: [],
      search: "",
      measurementSearch: '',
      categoryFilter: null,
      myTimeOut: null,
      selectedProductIds: [],
    }
  },
  computed: {
    areAllCurrentPageSelected() {
      if (!this.paginateData.data || this.paginateData.data.length === 0) {
        return false;
      }

      return this.paginateData.data.every(product => this.selectedProductIds.includes(product.id));
    },
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await axios.get('/dashboard/api/categories');
        this.categories = response.data;
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    },
    toggleVariations(index) {
      this.$set(this.paginateData.data[index], 'showVariations', !this.paginateData.data[index].showVariations);
    },
    quantityUpdate(variationId, i, k, action) {
      const variation = this.paginateData.data[i].variation[k];
      const product = this.paginateData.data[i];

      if (action === 'plus') {
        variation.quantity++;
        product.total_stock++;
      } else {
        if (variation.quantity > 0) {
          variation.quantity--;
          product.total_stock--;
        }
      }

      axios.post("/dashboard/api/update-variant-stock", {
        id: variationId,
        type: action
      }).then(resp => {
        console.log(resp.data);
      }).catch(err => {
        console.error(err.response?.data);
        // Revert on error
        if (action === 'plus') {
          variation.quantity--;
          product.total_stock--;
        } else {
          variation.quantity++;
          product.total_stock++;
        }
      });
    },
    formatPrice(price) {
      return parseFloat(price || 0).toFixed(2);
    },
    getStockClass(stock) {
      if (stock === 0) return 'text-danger';
      if (stock < 10) return 'text-warning';
      return 'text-success';
    },
    clearFilters() {
      this.search = "";
      this.measurementSearch = "";
      this.categoryFilter = null;
      this.getProductList();
    },
    filterProduct() {
      if (this.myTimeOut != null) {
        clearTimeout(this.myTimeOut);
      }
      this.myTimeOut = setTimeout(() => {
        this.getProductList();
      }, 500);
    },
    async getProductList(page = 1) {
      try {
        const params = {
          search: this.search,
          measurementSearch: this.measurementSearch,
          category_id: this.categoryFilter,
          page: page
        };

        const response = await axios.get('/dashboard/api/get-product-list', { params });
        this.paginateData = response.data;

        // Initialize showVariations property
        this.paginateData.data.forEach(product => {
          this.$set(product, 'showVariations', false);
        });
      } catch (err) {
        console.error(err.response?.data);
        swal.fire("Ø®Ø·Ø£", "ÙØ´Ù„ ØªØ­Ù…ÙŠÙ„ Ø§Ù„Ù…Ù†ØªØ¬Ø§Øª", "error");
      }
    },
    printBarcode(productId) {
      // Open barcode in a new tab
      window.open(`/dashboard/product-barcode/${productId}`, '_blank');
    },
    printSingleLabel(productId) {
      window.open(`/dashboard/product-label/${productId}`, '_blank');
    },
    printBulkLabels() {
      if (!this.selectedProductIds.length) {
        swal.fire("تنبيه", "حدد المنتجات أولاً لطباعة الليبل الجماعي", "warning");
        return;
      }

      const ids = this.selectedProductIds.join(',');
      window.open(`/dashboard/product-labels?ids=${ids}`, '_blank');
    },
    toggleProductSelection(productId) {
      if (this.selectedProductIds.includes(productId)) {
        this.selectedProductIds = this.selectedProductIds.filter(id => id !== productId);
        return;
      }
      this.selectedProductIds.push(productId);
    },
    toggleSelectAllCurrentPage() {
      const currentPageIds = this.paginateData.data.map(product => product.id);

      if (this.areAllCurrentPageSelected) {
        this.selectedProductIds = this.selectedProductIds.filter(id => !currentPageIds.includes(id));
        return;
      }

      this.selectedProductIds = Array.from(new Set([...this.selectedProductIds, ...currentPageIds]));
    },
    async deleteProduct(id, index) {
      const result = await swal.fire({
        title: 'Ù‡Ù„ Ø£Ù†Øª Ù…ØªØ£ÙƒØ¯ØŸ',
        text: "Ù„Ù† ØªØªÙ…ÙƒÙ† Ù…Ù† Ø§Ø³ØªØ¹Ø§Ø¯Ø© Ù‡Ø°Ø§ Ø§Ù„Ù…Ù†ØªØ¬!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ù†Ø¹Ù…ØŒ Ø§Ø­Ø°ÙÙ‡!',
        cancelButtonText: 'Ø¥Ù„ØºØ§Ø¡'
      });

      if (result.isConfirmed) {
        try {
          const response = await axios.post("/dashboard/api/delete-product", { productId: id });
          if (response.data.status === "ok") {
            swal.fire("ØªÙ… Ø§Ù„Ø­Ø°Ù!", response.data.msg, "success");
            this.paginateData.data.splice(index, 1);
            this.selectedProductIds = this.selectedProductIds.filter(productId => productId !== id);
          }
        } catch (err) {
          console.error(err.response?.data);
          swal.fire("Ø®Ø·Ø£", "ÙØ´Ù„ Ø­Ø°Ù Ø§Ù„Ù…Ù†ØªØ¬", "error");
        }
      }
    }
  },
  mounted() {
    this.fetchCategories();
    this.getProductList();
  },
}
</script>

<style scoped>
.header-actions {
  display: flex;
  gap: 0.5rem;
  align-items: center;
}

.bulk-selection-toolbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #f8f9fa;
  border: 1px solid #e5e7eb;
  border-radius: 8px;
  padding: 0.5rem 0.75rem;
  margin-bottom: 1rem;
}

.product-select-box {
  padding: 0.55rem 0.8rem 0.15rem 0.8rem;
}

.selection-check {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  font-size: 0.85rem;
  color: #334155;
  margin: 0;
}

.selection-check input {
  cursor: pointer;
}

.selected-count {
  font-size: 0.85rem;
  color: #475569;
  font-weight: 600;
}

/* Product Card */
.product-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
}

/* Product Image */
.product-image-container {
  position: relative;
  height: 200px;
  overflow: hidden;
  background: #f8f9fa;
}

.product-image {
  width: 100%;
  height: 100%;
  object-fit: contain;
  transition: transform 0.3s ease;
}

.product-card:hover .product-image {
  transform: scale(1.05);
}

.product-badge {
  position: absolute;
  top: 10px;
  right: 10px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
}

/* Product Info */
.product-info {
  padding: 1rem;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.product-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 0.5rem;
}

.product-title {
  font-size: 1.1rem;
  font-weight: 700;
  color: #2d3748;
  margin: 0;
  flex: 1;
}

.product-id {
  color: #718096;
  font-size: 0.85rem;
  font-weight: 500;
}

.product-meta {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 0.75rem;
  flex-wrap: wrap;
}

.product-description {
  margin-bottom: 1rem;
  line-height: 1.5;
}

/* Price Summary */
.price-summary {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 0.75rem;
  margin-bottom: 1rem;
}

.price-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.5rem;
}

.price-row:last-child {
  margin-bottom: 0;
}

.price-label {
  font-size: 0.85rem;
  color: #718096;
  font-weight: 500;
}

.price-value {
  font-size: 0.95rem;
  font-weight: 700;
}

.price-value.purchase {
  color: #f59e0b;
}

.price-value.sale {
  color: #10b981;
}

.price-value.discount {
  color: #667eea;
}

/* Stock Summary */
.stock-summary {
  background: #f0f4ff;
  border-radius: 8px;
  padding: 0.5rem 0.75rem;
  margin-bottom: 1rem;
}

.stock-info {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.9rem;
}

.stock-info i {
  color: #667eea;
}

.stock-label {
  color: #718096;
  font-weight: 500;
}

.stock-value {
  font-weight: 700;
  margin-right: auto;
}

/* Variations */
.variations-toggle {
  margin-bottom: 1rem;
}

.variations-container {
  margin-bottom: 1rem;
  background: #f8f9fa;
  border-radius: 8px;
  padding: 0.75rem;
}

.variations-table {
  margin: 0;
  font-size: 0.85rem;
}

.variations-table thead th {
  background: #667eea;
  color: white;
  font-weight: 600;
  border: none;
  padding: 0.5rem;
  font-size: 0.8rem;
}

.variations-table tbody td {
  padding: 0.5rem;
  vertical-align: middle;
}

.variation-name {
  font-weight: 600;
  color: #2d3748;
}

.attribute-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.25rem;
  margin-top: 0.25rem;
}

.attribute-tag {
  background: #e0e7ff;
  color: #4c51bf;
  padding: 2px 6px;
  border-radius: 4px;
  font-size: 0.7rem;
  font-weight: 500;
}

/* Stock Controls */
.stock-controls {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.stock-btn {
  width: 24px;
  height: 24px;
  border-radius: 4px;
  border: 1px solid #d1d5db;
  background: white;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  font-size: 0.75rem;
}

.stock-btn:hover:not(:disabled) {
  background: #667eea;
  color: white;
  border-color: #667eea;
}

.stock-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.stock-btn.minus {
  color: #dc2626;
}

.stock-btn.plus {
  color: #059669;
}

.stock-quantity {
  font-weight: 700;
  min-width: 30px;
  text-align: center;
}

/* Product Actions */
.product-actions {
  display: flex;
  gap: 0.5rem;
  margin-top: auto;
}

.product-actions .btn {
  flex: 1;
  font-size: 0.85rem;
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 3rem 1rem;
}

.empty-state i {
  font-size: 4rem;
  color: #cbd5e0;
  margin-bottom: 1rem;
}

.empty-state h5 {
  color: #2d3748;
  margin-bottom: 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
  .product-image-container {
    height: 150px;
  }

  .product-title {
    font-size: 1rem;
  }

  .price-summary {
    padding: 0.5rem;
  }

  .variations-table {
    font-size: 0.75rem;
  }
}

/* Badge Customization */
.badge {
  font-size: 0.75rem;
  padding: 0.35em 0.65em;
}

/* Input Group */
.input-group-text {
  background: #f8f9fa;
  border-right: none;
}

.input-group .form-control {
  border-left: none;
}

.input-group .form-control:focus {
  border-color: #ced4da;
  box-shadow: none;
}

.input-group .form-control:focus + .input-group-text {
  border-color: #667eea;
}
</style>
