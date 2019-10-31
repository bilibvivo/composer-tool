create table ytb
(
	id integer
		constraint ytb_pk
			primary key autoincrement,
	keyword varchar,
	video_id varchar,
	title varchar,
	description varchar,
	thumbnails varchar,
	video_time varchar,
	create_time int not null
);

create unique index ytb_video_id_uindex
	on ytb (video_id);

