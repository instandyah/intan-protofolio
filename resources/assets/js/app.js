
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import notification from './components/Notification.vue';
import notification1 from './components/Notification1.vue';
import notificationfull from './components/Notificationfull.vue';



// Vue.component('notification', require('./components/Notification.vue'));
var isLoggedIn = $("meta[name=login-status]").attr('content');
var userId = $('meta[name="userId"]').attr('content');
console.log(userId);
// console.log(isLoggedIn);
if (isLoggedIn) {
  const notif = new Vue({
      el: '#app',
      components : {
        notification, notification1
      },
      data : {
        notifications : '',
        timer: ''
      },
      created() {

          axios.post('/project/notification/get').then(response => {
            this.notifications = response.data;
            console.log(response);
          });

        var userId = $('meta[name="userId"]').attr('content');
        console.log('App.User.'+userId);
        // Echo.private('App.User.'+userId).notification((notification) => {
        //     console.log(notification);
        // });
        // Echo.private('App.Models.Admin.'+userId).notification((notification) => {
        //   // this.notifications.push(notification);
        //   console.log(notification);
        // });
        this.timer = setInterval(this.getnotif, 4000);
      },
      methods :{
        getnotif : function () {
          axios.post('/project/notification/get').then(response => {
            this.notifications = response.data;
          });
        },
      },
      beforeDestroy() {
        clearInterval(this.timer)
      }
  });

const notifull = new Vue ({
  el : '.isi',
  components :{
    notificationfull
  },
});

}
