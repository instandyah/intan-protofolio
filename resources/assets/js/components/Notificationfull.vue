<template>

  <table class="table table-striped table-hover">
    <tbody>
      <tr class="mousechange" v-for = "notification in notificationss" v-on:click="MarkAsRead(notification)">

        <td style="width: 15px"><i class="fa fa-circle-o"></i></td>
        <td class="isi" >{{ notification.data.data.text }}</td>
        <td style="width: 170px"> </td>

      </tr>
    </tbody>
  </table>
</template>

<script>
    export default {
      props: ['notificationss'],
      mounted() {
            console.log(this.notificationss);
        },
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
