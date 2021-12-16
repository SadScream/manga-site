insert into manga_genres(manga_id, genre_id) 
	select manga.id as manga_id, genre.id as genre_id from manga 
    cross join genre on genre.id in (8,1,7,4) where manga.id=1;
insert into manga_genres(manga_id, genre_id) 
	select manga.id as manga_id, genre.id as genre_id from manga 
    cross join genre on genre.id in (4,7,8) where manga.id=2;