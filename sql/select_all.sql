-- select * from manga;
-- select * from genre;
-- select * from publisher;
-- select * from manga_publishers;
-- select * from manga_genres;
-- select * from manga_types;
-- select * from manga_name;
select * from manga_name where id=2 AND ((LCASE(name_ru) LIKE LCASE('%solo%')) OR (LCASE(name_en) LIKE LCASE('%solo%')))