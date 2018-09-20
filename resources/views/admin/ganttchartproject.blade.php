<!DOCTYPE html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Progress Proyek</title>
	<script src="{{URL::asset('gantt/codebase/dhtmlxgantt.js')}}"></script>
	<script src="{{URL::asset('gantt/codebase/ext/dhtmlxgantt_tooltip.js')}}"></script>
	<link rel="stylesheet" href="{{URL::asset('gantt/codebase/dhtmlxgantt.css')}}">
	<link rel="shortcut icon" href="{{{ asset('dist/img/helfalogo.png') }}}">
	<script src="{{URL::asset('gantt/samples/common/testdata.js')}}"></script>
	<style>
		html, body {
			height: 100%;
			padding: 0px;
			margin: 0px;
			overflow: hidden;
    }

		.complex_gantt_bar {
			background: transparent;
			border: none;
		}

		.complex_gantt_bar .gantt_task_progress {
			display: none;
		}
	</style>
</head>

<body>
{{-- <div id="mygantchartdata" style="display: none;">
{{ $project }}
</div> --}}
<div id="gantt_here" style='width:100%; height:100%;'></div>
<script>

gantt.config.columns =  [
	{name:"text",       label:"Task name",  tree:true, width:"*" },
	{name:"start_date", label:"Start time", align:"center" },
	{name:"end_date",   label:"End date",   align:"center", width:100 },
];
	// gantt.config.drag_move = false;
	// gantt.config.drag_progress = false;
	// gantt.config.drag_resize = false;
	gantt.config.show_links = true;
	gantt.config.show_progress = true;
	gantt.config.show_errors = false;
	gantt.config.readonly = true;
	gantt.templates.task_text=function(start,end,task){
    return "";
};
	gantt.config.scale_unit = "month";
	gantt.config.step = 1;
	gantt.config.date_scale = "%F, %Y";
	gantt.config.min_column_width = 50;

	gantt.config.scale_height = 90;

	// var monthScaleTemplate = function (date) {
	// 	var dateToStr = gantt.date.date_to_str("%M");
	// 	var endDate = gantt.date.add(date, 2, "month");
	// 	return dateToStr(date) + " - " + dateToStr(endDate);
	// };
	var weekScaleTemplate = function (date) {
	var dateToStr = gantt.date.date_to_str("%d %M");
	var endDate = gantt.date.add(gantt.date.add(date, 1, "week"), -1, "day");
	return dateToStr(date) + " - " + dateToStr(endDate);
};

	// gantt.config.subscales = [
	// 	{unit: "month", step: 3, template: monthScaleTemplate},
	// 	{unit: "month", step: 1, date: "%M"}
	// ];
	gantt.config.subscales = [
		{unit: "week", step: 1, template: weekScaleTemplate},
		{unit: "day", step: 1, date: "%D"}
	];
  gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";

	gantt.init("gantt_here");
  gantt.templates.task_class = function (start, end, task) {
  if (task.splitStart)
    return "complex_gantt_bar";
};
gantt.templates.task_text = function (start, end, task) {
  if (!task.splitStart)
	{if (!task.progress_teks) {
		return "<b>Tugas:</b>	"+task.text+",<b> PIC:</b> " + task.users;
	} else {
		if (!task.subtugas) {
			if (!task.parent) {
				return "<b>Proyek:</b> "+task.text+",<b> Proyek Manajer:</b> " + task.users + ", <b>Progress:</b> "+task.progress_teks+"%";
			} else {
				return "<b>Tugas:</b> "+task.text+",<b> PIC:</b> " + task.users + ", <b>Progress:</b> "+task.progress_teks+"%";
			}

		} else {
			if (!task.confirm_progress) {
				return "<b> PIC:</b> " + task.users + ", <b>Progress:</b> "+task.progress_teks+"% (Belum dikonfirmasi)";
			} else {
				return "<b> PIC:</b> " + task.users + ", <b>Progress:</b> "+task.progress_teks+"% ("+task.confirm_progress+")";
			}
		}

	}

	}

  var lw = Math.round(task.splitStart * 100 / task.duration);
  var rw = Math.round(100 - task.splitEnd * 100 / task.duration);
	if (!task.confirm_progress) {
		var left = "<div class='gantt_task_line' style='left:0px; width:" + lw + "%;'><b> PIC:</b> " + task.users + ", <b>Progress:</b> "+task.progress_teks+"% (Belum dikonfirmasi)</div>";
	} else {
		var left = "<div class='gantt_task_line' style='left:0px; width:" + lw + "%;'><b> PIC:</b> " + task.users + ", <b>Progress:</b> "+task.progress_teks+"% ("+task.confirm_progress+")</div>";
	}
	if (!task.confirm_progress) {
		var right = "<div class='gantt_task_line' style='right:0px; width:" + rw + "%'><b> PIC:</b> " + task.users + ", <b>Progress:</b> "+task.progress_teks+"% (Belum dikonfirmasi)</div>";
	} else {
		var right = "<div class='gantt_task_line' style='right:0px; width:" + rw + "%'><b> PIC:</b> " + task.users + ", <b>Progress:</b> "+task.progress_teks+"% ("+task.confirm_progress+")</div>";
	}
  return right + left;
};

gantt.templates.tooltip_text = function(start,end,task){
	if (task.status == null) {
		return "<b>Task:</b> "+task.text+"<br/><b>PIC:</b> " + task.users;
	} else if (task.status == 'Selesai') {
		if (task.confirm == null) {
			return "<b>Task:</b> "+task.text+"<br/><b>PIC:</b> " + task.users + "<br/><b>Status:</b> "+task.status+" (Belum dikonfirmasi) <br/><b> Selesai pada:</b> "+task.ed;
		} else {
			return "<b>Task:</b> "+task.text+"<br/><b>PIC:</b> " + task.users + "<br/><b>Status:</b> "+task.status+" 100% ("+task.confirm+")<br/><b> Selesai pada:</b> "+task.ed;
		}
	} else if (task.status == 'Ditunda') {
		if (task.confirm == null) {
			return "<b>Task:</b> "+task.text+"<br/><b>PIC:</b> " + task.users + "<br/><b>Status:</b> "+task.status+" "+task.progress_teks+"% (Belum dikonfirmasi)";
		} else {
			return "<b>Task:</b> "+task.text+"<br/><b>PIC:</b> " + task.users + "<br/><b>Status:</b> "+task.status+" "+task.progress_teks+"% ("+task.confirm+")";
		}
	} else {
		if (!task.due_date) {
			if (task.confirm_progress == null) {
				return "<b>Task:</b> "+task.text+"<br/><b>PIC:</b> " + task.users + "<br/><b>Status:</b> "+task.status+" "+task.progress_teks+"% (Belum dikonfirmasi)<br /><b>Terakhir update:</b> "+task.updated_at+"<br/>Deadline tidak ditentukan";
			} else {
				return "<b>Task:</b> "+task.text+"<br/><b>PIC:</b> " + task.users + "<br/><b>Status:</b> "+task.status+" "+task.progress_teks+"% ("+task.confirm_progress+")<br /><b>Terakhir update:</b> "+task.updated_at+"<br/>Deadline tidak ditentukan";
			}
		} else {
			if (task.confirm_progress == null) {
				return "<b>Task:</b> "+task.text+"<br/><b>PIC:</b> " + task.users + "<br/><b>Status:</b> "+task.status+" "+task.progress_teks+"% (Belum dikonfirmasi)<br /><b>Terakhir update:</b> "+task.updated_at+"<br/>Deadline: "+task.due_date;
			} else {
				return "<b>Task:</b> "+task.text+"<br/><b>PIC:</b> " + task.users + "<br/><b>Status:</b> "+task.status+" "+task.progress_teks+"% ("+task.confirm_progress+")<br /><b>Terakhir update:</b> "+task.updated_at+"<br/>Deadline: "+task.due_date;
			}
		}


	}
};
	// gantt.parse(mytask);
  var id = '{{$id_project}}';
	var prog = '{{$progress}}';
console.log(id);
  console.log();
  gantt.load("/admin/loadganttchart/"+id+"/"+prog)
</script>
</body>
