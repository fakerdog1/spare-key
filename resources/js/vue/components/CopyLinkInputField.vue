<template>
  <div class="input-group">
    <input
        type="text"
        class="form-control"
        v-model="$props.url"
        readonly
    />
    <div class="input-group-append">
      <button
          class="btn btn-outline-secondary"
          type="button"
          @click="copyLink"
      >
        Copy
      </button>
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'CopyLinkInputField',
  props: {
    url: {
      type: String,
      required: true
    }
  },
  setup(props) {
    const copyLink = () => {
      navigator.clipboard.writeText(props.url);
    };

    return {
      copyLink
    };
  }
});
</script>