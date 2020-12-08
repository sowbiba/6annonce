INSERT IGNORE INTO `user`(
           `username`,
           `password`,
           `email`,
           `enabled`,
           `salt`
) VALUES
    ('sowbiba', 'sowbiba', 'sowbiba@hotmail.com', 1, 'sowbiba'),
    ('chris-gaye', 'chris-gaye', 'chris-gaye@gmail.com', 1, 'chris-gaye'),
    ('nadd', 'nadd', 'nadd@gmail.com', 1, 'nadd'),
    ('mamichou', 'mamichou', 'mamichou@gmail.com', 1, 'mamichou')
;

INSERT IGNORE INTO `user_role` (
            `user_id`,
            `role_id`
) VALUES
    ((SELECT `id` FROM `user` WHERE `username`='sowbiba'), (SELECT `id` FROM `role` WHERE `name`='SUPER_ADMIN')),
    ((SELECT `id` FROM `user` WHERE `username`='chris-gaye'), (SELECT `id` FROM `role` WHERE `name`='SUPER_ADMIN')),
    ((SELECT `id` FROM `user` WHERE `username`='nadd'), (SELECT `id` FROM `role` WHERE `name`='MEMBER')),
    ((SELECT `id` FROM `user` WHERE `username`='mamichou'), (SELECT `id` FROM `role` WHERE `name`='CLIENT'))
;