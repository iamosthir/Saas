<template>
  <div class="dynamic-custom-fields">
    <div v-for="field in fields" :key="field.id" class="form-group mb-3">
      <label class="form-label">
        {{ field.field_label }}
        <span v-if="field.is_required" class="text-danger">*</span>
      </label>

      <!-- Text Field -->
      <input
        v-if="field.field_type === 'text'"
        type="text"
        :value="values[field.field_key]"
        @input="updateValue(field.field_key, $event.target.value)"
        :required="field.is_required"
        class="form-control"
        :placeholder="field.field_label"
      />

      <!-- Number Field -->
      <input
        v-else-if="field.field_type === 'number'"
        type="number"
        :value="values[field.field_key]"
        @input="updateValue(field.field_key, $event.target.value)"
        :required="field.is_required"
        class="form-control"
        :placeholder="field.field_label"
      />

      <!-- Date Field -->
      <input
        v-else-if="field.field_type === 'date'"
        type="date"
        :value="values[field.field_key]"
        @input="updateValue(field.field_key, $event.target.value)"
        :required="field.is_required"
        class="form-control"
      />

      <!-- Select Field -->
      <select
        v-else-if="field.field_type === 'select'"
        :value="values[field.field_key]"
        @change="updateValue(field.field_key, $event.target.value)"
        :required="field.is_required"
        class="form-control"
      >
        <option value="">Select...</option>
        <option
          v-for="(option, index) in field.select_options"
          :key="index"
          :value="option"
        >
          {{ option }}
        </option>
      </select>

      <small v-if="field.is_required" class="form-text text-muted">
        This field is required
      </small>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DynamicCustomFields',
  props: {
    fields: {
      type: Array,
      default: () => []
    },
    values: {
      type: Object,
      default: () => ({})
    },
    level: {
      type: String,
      default: 'header', // 'header' or 'item'
      validator: value => ['header', 'item'].includes(value)
    }
  },
  methods: {
    updateValue(key, value) {
      const updatedValues = { ...this.values, [key]: value };
      this.$emit('update', updatedValues);
    }
  }
};
</script>

<style scoped>
.dynamic-custom-fields {
  padding: 15px;
  background-color: #f8f9fa;
  border-radius: 5px;
  margin-bottom: 20px;
}

.form-label {
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #2d3748;
}

.form-control {
  border: 1px solid #cbd5e0;
  padding: 0.5rem 0.75rem;
  border-radius: 0.375rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
  border-color: #4299e1;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(66, 153, 225, 0.25);
}

.text-danger {
  color: #e53e3e;
  margin-left: 4px;
}

.form-text {
  font-size: 0.875rem;
  margin-top: 0.25rem;
}
</style>
