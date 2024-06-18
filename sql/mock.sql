USE SquishFactory;

INSERT INTO `Admins` (Username, Password)
VALUES ('Admin', '$2y$10$CnWEy8t8/BkX5i.Ck9gMAe97KOGJoEzjLBP/RrwKbrZEElSSoMA4G');

INSERT INTO `Accessories` (Name, Price, Filepath)
VALUES ('Devil Horns', 1500, '/assets/accessories/devil_horns.png'),
       ('Devil Wings', 1000, '/assets/accessories/devil_wings.png'),
       ('Headphones', 500, '/assets/accessories/headphones.png'),
       ('Shroom Hat', 2000, '/assets/accessories/shroom_hat.png'),
       ('Shroom Horns', 1500, '/assets/accessories/shrooms.png');

INSERT INTO `Mellows` (Name, Price, Filepath)
VALUES ('Arielis The Axolotl', 42000, '/assets/custom-mellows/arielis.png'),
       ('Harley The Strawberry Milk Cow', 2000, '/assets/custom-mellows/harley.png'),
       ('Le Shroom', 2000, '/assets/custom-mellows/shroom.png');

INSERT INTO `Examples` (Filepath, AdminID)
VALUES ('/assets/landing/alpha.png', 1),
       ('/assets/landing/bravo.png', 1),
       ('/assets/landing/harley.png', 1);

INSERT INTO `Users` (FirstName, LastName, BillingAddress, Phone, Email, Username, Password)
VALUES ('John', 'Doe', 'Lane Avenue 27', '+31 6 12345678', 'test@domain.com', 'Johnny', '$2y$10$hIN442Iz4qJeRG82rwVEGe0Iu.AN8jJXTmPcMadQzWt2Qii4UY9iO');

