<template>
  <li class="dropdown notifications-menu">
    <!-- Menu toggle button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-bell-o"></i>
      <span  v-if="notifications.length !== 0" class="label label-warning">
        {{notifications.length}}</span>
    </a>
    <ul class="dropdown-menu">
      <li v-if="notifications.length !== 0" class="header">Kamu memiliki {{ notifications.length }} pemberitahuan baru</li>
      <li>
        <!-- Inner Menu: contains the notifications -->
        <ul class="menu">
          <li v-for ="notification in notifications"><!-- start notification -->
            <a href="#" v-on:click="MarkAsRead(notification)" >
              {{ notification.data.data.text }}
            </a>
          </li>
          <li v-if="notifications.length == 0">
            <a>Tidak ada pemberitahuan baru</a>
          </li>
          <!-- end notification -->
        </ul>
      </li>
      <li class="footer"><a href="/admin/notification/getall">Lihat semua pemberitahuan</a></li>
    </ul>
  </li>
</template>

<script>
    export default {props: ['notifications', 'NOTIFICATION_TYPES'],
    methods : {
      MarkAsRead : function(notification) {
        var data = {
          id : notification.id
        };
        const NOTIFICATION_TYPES = {
          tugas : 'App\\Notifications\\NotifyAdmin',
          subtugas : 'App\\Notifications\\SubtugasNotifyAdmin',
          anggota : 'App\\Notifications\\AnggotaNotifyAdmin',
          project : 'App\\Notifications\\ProjectNotifyAdmin',
          bagitugas : 'App\\Notifications\\PembagiantugasNotifyAdmin'
        };
        axios.post('/project/notification/read', data).then(response => {
          switch (notification.type) {
            case NOTIFICATION_TYPES.tugas:
                  if (notification.data.data.type === 'delete') {
                    window.location.href = "/project/"+notification.data.data.id_project;
                  } else if (notification.data.data.type === 'konfirm') {
                    window.location.href = "/project/konfirmasi/"+notification.id;
                  }
                  else {
                    window.location.href = "/project/tugas/"+notification.data.data.id_tugas;
                  }
              break;

            case NOTIFICATION_TYPES.subtugas:
                  window.location.href = "/project/tugas/"+notification.data.data.id_tugas;

              break;
              case NOTIFICATION_TYPES.anggota:
                  if (notification.data.data.type === 'delete') {
                    window.location.href = "/admin/anggota";
                  } else {
                    window.location.href = "/admin/anggota/"+notification.data.data.id_anggota;
                  }

                break;

                case NOTIFICATION_TYPES.project:
                  if (notification.data.data.type === 'delete') {
                    window.location.href = "/admin/project";
                  } else if (notification.data.data.type === 'konfirm') {
                    window.location.href = "/project/konfirmasi/"+notification.id;
                  }
                   else {
                    window.location.href = "/project/"+notification.data.data.id_project;
                  }

                  break;

                  case NOTIFICATION_TYPES.bagitugas:
                      if (notification.data.data.type === 'delete') {
                        window.location.href = "/project/"+notification.data.data.id_project;
                      } else if (notification.data.data.type === 'editanggota') {
                        window.location.href = "/anggota/"+notification.data.data.id_project+"/aktivitas";
                      } else {
                        window.location.href = "/project/anggota/"+notification.data.data.id_anggota+"/"+notification.data.data.id_project;
                      }
                    break;
            default:

          }
        });
      },

      gotofull : function (){
        axios.post('/admin/notification/getall');
      }
    }
    }
</script>
