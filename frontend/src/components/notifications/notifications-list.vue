<template>
  <div class="notifications-list">
    <NotificationMessage v-for="notification in notifications" :key="notification.id" :notification="notification"/>
  </div>  
</template>
      
<script>
import { mapState } from "vuex";
import NotificationMessage from "@/components/notifications/notification-message.vue"

export default {

  name: "NotificationsList",

  components: {    
    NotificationMessage
  },

  computed: mapState(['notifications'])  
}
</script>

<style>
.notifications-list {
    position: fixed;
    display: flex;
    flex-flow: column nowrap;
    gap: 20px;
    top: 120px;
    right: 0px;
    z-index: 1000;
}
</style>