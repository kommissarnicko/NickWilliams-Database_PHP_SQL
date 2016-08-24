-------------------------------------------------------------------------------
-- ENTITY CREATION QUERIES
-------------------------------------------------------------------------------

-- Add family entity
INSERT INTO family
(
    name
)
VALUES
(
    [family_name]
);

-- Add asset entity
INSERT INTO asset
(
    name, description
)
VALUES
(
    [asset_name], [asset_description]
);

-- Add fief entity
INSERT INTO fief
(
    name, owner
)
VALUES
(
    [fief_name],
    (SELECT id FROM family WHERE name='[family_name]')
);

-- Add person entity
INSERT INTO person
(
    first_name, middle_name, loyalty, age
)
VALUES
(
    [first_name], [middle_name],
    (SELECT id FROM family WHERE name='[family_name]'),
    [age]
);


-------------------------------------------------------------------------------
-- RELATIONSHIP CREATION QUERIES
-------------------------------------------------------------------------------

-- Adding parent/child relationships
INSERT INTO parent_child
(
    pid, cid
)
VALUES
(
    (SELECT id FROM people WHERE id=[parent_id]),
    (SELECT id FROM people WHERE id=[child_id])
);

-- Adding lord/vassal relationships
INSERT INTO lord_vassal
(
    lid, vid
)
VALUES
(
    (SELECT id FROM family WHERE id=[lord_id]),
    (SELECT id FROM family WHERE id=[vassal_id])
);

-- Adding fief/asset relationships
INSERT INTO fief_asset
(
    fid, aid, quantity
)
VALUES
(
    (SELECT id FROM fief WHERE id=[fief_id]),
    (SELECT id FROM asset WHERE id=[asset_id]),
    [quantity]  
);


-------------------------------------------------------------------------------
-- INFORMATIONAL QUERIES
-------------------------------------------------------------------------------

-- Getting a list of family names (for add family table)
SELECT family.id, family.name FROM family ORDER BY name

-- Getting a list of person info (for add person table)
SELECT person.id, person.first_name, person.middle_name, family.name, person.age FROM person INNER JOIN 
family ON person.loyalty = family.id ORDER BY family.name

-- Getting a list of fief names with owning family (for add fief table)
SELECT fief.id, fief.name, family.name FROM fief 
INNER JOIN family ON fief.owner = family.id ORDER BY id

-- Getting a list of assets (for add asset table)
SELECT asset.id, asset.name, asset.description FROM asset ORDER BY name

-- Getting a list of families that do not currently have a liege
SELECT family.id, family.name FROM family 
WHERE family.id NOT IN
(
    SELECT family.id FROM family INNER JOIN
    lord_vassal ON family.id = lord_vassal.vid
)

-- Getting family names for person.loyalty and using them as last name
SELECT person.id, family.name FROM person INNER JOIN 
family ON person.loyalty = family.id 
WHERE person.id = [person_id]

-- Getting parents for child, also using family names as last name
SELECT person.id, person.first_name, person.middle_name, family.name FROM person INNER JOIN
parent_child ON parent_child.pid = person.id INNER JOIN
family ON person.loyalty = family.id
WHERE parent_child.cid = [person_id]

-- Getting children for parent_child, also using family names as last name
SELECT person.id, person.first_name, person.middle_name, family.name FROM person INNER JOIN
parent_child ON parent_child.cid = person.id INNER JOIN
family ON person.loyalty = family.id
WHERE parent_child.pid = [person_id]

-- Getting assets for given fief
SELECT asset.id, asset.name, asset.description FROM asset INNER JOIN
fief_asset ON fief_asset.aid = asset.id INNER JOIN
fief ON fief_asset.fid = fief.id
WHERE fief.id = [fief.id]

-- Getting vassals for given family
SELECT family.id, family.name FROM family INNER JOIN
lord_vassal ON lord_vassal.vid = family.id
WHERE lord_vassal.lid = [family_id]

-- Getting liege(s) for given family
SELECT family.id, family.name FROM family INNER JOIN
lord_vassal ON lord_vassal.lid = family.id
WHERE lord_vassal.vid = [family_id]

-- Getting fiefdoms owned by given family
SELECT fief.id, fief.name FROM fief
WHERE fief.owner = [family_id]

-- Getting members of a given family
SELECT person.id, person.first_name, person.middle_name, family.name FROM person INNER JOIN 
family ON person.loyalty = family.id WHERE family.id = [family_id]