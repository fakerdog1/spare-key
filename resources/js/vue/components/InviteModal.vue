<template>
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inviteModal">
    Invite
  </button>

  <!-- Modal -->
  <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="inviteModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="group-invite-field">
            <copy-link-input-field url="www.example.com" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import { defineComponent, ref } from 'vue';
import axios from 'axios';
import CopyLinkInputField from "@/vue/components/CopyLinkInputField.vue";

export default defineComponent({
  name: 'InviteModal',
  components: {
    CopyLinkInputField
  },
  props: {
    postUrl: {
      type: String,
      required: true
    }
  },
  setup(props) {
    const showModal = ref(false);

    const form = ref({
      email: ''
    });

    const errors = ref({});
    const generalErrors = ref(null);
    const response = ref(null);

    const openModal = () => {
      showModal.value = true;
    };

    const closeModal = () => {
      showModal.value = false;
    };

    const clearResData = () => {
      response.value = null;
      errors.value = {};
      generalErrors.value = null;
    };

    const clearForm = () => {
      form.value.email = '';
    };

    const submitForm = async () => {
      clearResData();

      try {
        const res = await axios.post(props.postUrl, form.value);
        response.value = res.data.message;

        clearForm();
        // Optionally close the modal after a successful submission
        // closeModal();
      }
      catch (error) {
        if (error.response && error.response.status === 422) {
          errors.value = error.response.data.errors;
        } else {
          generalErrors.value = {
            message: error.response.data.message,
            error: error.response.data.error,
          };
        }
      }
    };

    return {
      // showModal,
      // openModal,
      // closeModal,
      form,
      response,
      errors,
      generalErrors,
      submitForm
    };
  }
});
</script>

<style>
/* Optional: Adjust z-index if necessary */
.modal-backdrop {
  z-index: 1040;
}

.modal {
  z-index: 1050;
}
</style>
