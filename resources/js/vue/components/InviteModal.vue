<template>
  <!-- Button trigger modal -->
  <button type="button"
      class="btn btn-primary"
      data-bs-toggle="modal"
      data-bs-target="#inviteModal"
  >
    Invite
  </button>

  <!-- Modal -->
  <div class="modal fade"
      id="inviteModal"
      tabindex="-1"
      aria-labelledby="inviteModalLabel"
      aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="inviteModalLabel">Modal title</h5>
          <button type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="group-invite-field">
            <copy-link-input-field :url="$props.inviteGroupUrl"/>
          </div>
          <div class="personal-invite-field">
            <auto-complete
                v-model="selectedUsers"
                :suggestions="filteredUsers"
                @complete="searchUsers"
                @input="handleInput"
                multiple
                :optionLabel="item => item.name || item.email"
                :field="['name', 'email']"
                placeholder="Search users..."
                :force-selection="false"
            >
              <template #item="slotProps">
                <div>
                  {{ slotProps.item.name ? `${slotProps.item.name} (${slotProps.item.email})` : slotProps.item.email }}
                </div>
              </template>
              <template #chip="slotProps">
                <div class="selected-user-chip">
                  {{ slotProps.value.name ? `${slotProps.value.name} (${slotProps.value.email})` : slotProps.value.email }}
                </div>
              </template>
            </auto-complete>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
          >Close
          </button>
          <button
              type="button"
              class="btn btn-primary"
              @click="sendInvites"
          >Send Invites</button>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import {defineComponent, ref} from "vue";
import axios from "axios";
import { debounce } from 'lodash';
import CopyLinkInputField from "@/vue/components/CopyLinkInputField.vue";
import AutoComplete from "primevue/autocomplete";

export default defineComponent({
  name: "InviteModal",
  components: {
    CopyLinkInputField,
    AutoComplete,
  },
  props: {
    roomId: {
      type: Number,
      required: true
    },
    inviteGroupUrl: {
      type: String,
      required: true
    },
    invitePersonalUrl: {
      type: String,
      required: true
    },
    searchUrl: {
      type: String,
      required: true
    }
  },
  setup(props) {
    const selectedUsers = ref([]);
    const filteredUsers = ref([]);

    const fetchUsers = async (query) => {
      if (query.length > 2) {
        try {
          const response = await axios.get(props.searchUrl, {
            params: {search: query},
          });
          console.log(response.data);

          // If no matches found and input looks like an email
          if (response.data.length === 0) {
            const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(query);
            if (isEmail) {
              filteredUsers.value = [
                {
                  name: '',
                  email: query,
                  isUnregistered: true
                }
              ];
              return;
            }
          }

          filteredUsers.value = response.data;
        }
        catch (error) {
          console.error('Error fetching users:', error);
          filteredUsers.value = [];
        }
      } else {
        filteredUsers.value = [];
      }
    };

    const handleInput = (event) => {
      if (event && typeof event === 'string') {
        const isEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(event);
        if (isEmail) {
          selectedUsers.value.push({
            name: '',
            email: event,
            isUnregistered: true
          });
        }
      }
    };

    const sendInvites = () => {
      console.log('Sending invites:', selectedUsers.value);
      const result = axios.post(props.invitePersonalUrl, {
        room_id: props.roomId,
        invitees: selectedUsers.value
      });

      const modal = new bootstrap.Modal(document.getElementById('inviteModal'));
      modal.hide();
    };

    const debouncedFetchUsers = debounce(fetchUsers, 200);

    const searchUsers = (event) => {
      console.log('searchUsers:', event.query);
      debouncedFetchUsers(event.query);
    };

    return {
      selectedUsers,
      filteredUsers,
      searchUsers,
      sendInvites,
      handleInput
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

.p-autocomplete-overlay {
  z-index: 1050 !important;
}

</style>
