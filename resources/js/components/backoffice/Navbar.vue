<template>
  <li class="nav-item dropdown dropdown-notifications">
    <a href="#notifications-panel" class="nav-link dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-envelope">
        <span class="badge badge-primary">{{unreads.length}}</span>
      </i>
    </a>

    <ul class="dropdown-menu">
      <li class="dropdown-item" v-for="unread in unreads" :key="unread.id"> Cliente <b> {{unread.data.cliente.nome}} </b> registado <b></b> </li>
      <li class="dropdown-item" v-if="unreads.length == 0">No notifications</li>
    </ul>
  </li>
</template>


<script>
export default {
  name: "dropdown-notifications",
  props: ["unreads", "userid"],
  mounted() {
    Echo.private("App.User." + this.userId).notification(notification => {
//      console.log(notification);
      /*let newUnreadNotifications = {
        data: { thread: notification.thread, user: notification.user }
      };
      this.unreadNotifications.push(newUnreadNotifications);*/
    });
  }
};
</script>