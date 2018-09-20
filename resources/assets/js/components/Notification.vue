<template>
  <li class="treeview notifications-menu">
    <a href="#">
      <i class="fa  fa-bell-o"></i>  <span>Pemberitahuan</span>

        <span  v-if="notifications.length !== 0" class="label label-warning" style="padding-top: 2px; padding-right: 3px; padding-bottom: 2px; padding-left: 3px; top: 9px; right: 7px; text-align: center; font-size: 9px;">
          {{notifications.length}}</span>


      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul data-role="listview" data-inset="true" class="treeview-menu">
      <li v-for ="notification in notifications">
        <a href="#" v-on:click="MarkAsRead(notification)" style="text-overflow: ellipsis;">
          {{ notification.data.data.text }}
        </a>
      </li>
      <li>
        <a href="/admin/notification/getall">Lihat semua pemberitahuan</a>
      </li>
    </ul>
  </li>
</template>

<script>
    export default {
      props: ['notifications', 'NOTIFICATION_TYPES'],
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
        }
      }
    }
</script>
