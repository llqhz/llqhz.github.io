
-- 用户表和帖子表，统计发帖最多的10个用户姓名



CREATE TABLE `users` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `name` char(10) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `contents` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`user_id` bigint(20) unsigned DEFAULT NULL,
`content` varchar(100) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 发帖最多的10个用户的姓名

select c.user_id,u.name,count(c.id) as cnt
from contents c left join users u on (c.user_id=u.id)
group by c.user_id,u.name
order by cnt desc limit 10;













































































