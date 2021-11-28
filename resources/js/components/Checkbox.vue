<template>
  <div class="custom-control custom-checkbox d-flex">
    <input
      :id="id || name"
      :name="name"
      :checked="internalValue"
      type="checkbox"
      class="custom-control-input"
      @click="handleClick"
    />
    <label :for="id || name" class="custom-control-label my-auto">
      <slot />
    </label>
  </div>
</template>

<script>
export default {
  name: "Checkbox",

  props: {
    id: { type: String, default: null },
    name: { type: String, default: "checkbox" },
    value: { type: Boolean, default: false },
    checked: { type: Boolean, default: false },
  },

  //Data
  data: () => ({
    internalValue: false,
  }),

  //Watch
  watch: {
    value(val) {
      this.internalValue = val;
    },

    checked(val) {
      this.internalValue = val;
    },

    internalValue(val, oldVal) {
      if (val !== oldVal) {
        this.$emit("input", val);
      }
    },
  },

  //Onload
  created() {
    this.internalValue = this.value;

    if ("checked" in this.$options.propsData) {
      this.internalValue = this.checked;
    }
  },

  //Methods
  methods: {
    handleClick(e) {
      this.$emit("click", e);

      if (!e.isPropagationStopped) {
        this.internalValue = e.target.checked;
      }
    },
  },
};
</script>
