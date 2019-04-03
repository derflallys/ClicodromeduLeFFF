<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\PFMRule;
use App\Entity\TagAssociation;
use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;

class AppFixtures extends Fixture
{
    /**
     * Retourne le tableau des données d'exemple à enregistrer en base de données
     * @return array
     * Les données sont dans un tableau de la forme :
     *
     *      [    attributs de la catégorie
     *          [tableau des mots de la catégorie]
     *          [tableau des règles de la catégorie]
     *          [tableau des associations de tags de la catégorie]
     *      ]
     *      [
     *           catégorie suivante
     *           ...
     *      ]
     *      ...
     */
    public function getData() {
        $data = [
            [
                'id' => 1,
                'code' => 'adj',
                'label' => 'adjectif',
                'words' => [
                    [
                        'value' => 'abordable',
                        'tags' => []
                    ],
                    [
                        'value' => 'abortif',
                        'tags' => []
                    ],
                    [
                        'value' => 'abouti',
                        'tags' => []
                    ],
                    [
                        'value' => 'classe',
                        'tags' => []
                    ],
                    [
                        'value' => 'clément',
                        'tags' => []
                    ],
                    [
                        'value' => 'coaxial',
                        'tags' => []
                    ],
                    [
                        'value' => 'drapé',
                        'tags' => []
                    ],
                    [
                        'value' => 'embêtant',
                        'tags' => []
                    ],
                    [
                        'value' => 'empressé',
                        'tags' => []
                    ],
                    [
                        'value' => 'international',
                        'tags' => []
                    ]
                ],
                'rules' => [],
                'tags' => []
            ],
            [
                'id' => 2,
                'code' => 'adv',
                'label' => 'adverbe',
                'words' => [
                    [
                        'value' => 'académiquement',
                        'tags' => []
                    ],
                    [
                        'value' => 'affablement',
                        'tags' => []
                    ],
                    [
                        'value' => 'annuellement',
                        'tags' => []
                    ],
                    [
                        'value' => 'longtemps',
                        'tags' => []
                    ],
                    [
                        'value' => 'pensivement',
                        'tags' => []
                    ],
                    [
                        'value' => 'quatrièmement',
                        'tags' => []
                    ],
                    [
                        'value' => 'simultanément',
                        'tags' => []
                    ],
                    [
                        'value' => 'superbement',
                        'tags' => []
                    ],
                    [
                        'value' => 'textuellement',
                        'tags' => []
                    ],
                    [
                        'value' => 'à priori',
                        'tags' => []
                    ]
                ],
                'rules' => [],
                'tags' => []
            ],
            [
                'id' => 3,
                'code' => 'advneg',
                'label' => 'adverbe négatif',
                'words' => [
                    [
                        'value' => 'guère',
                        'tags' => []
                    ],
                    [
                        'value' => 'jamais',
                        'tags' => []
                    ],
                    [
                        'value' => 'jamais plus',
                        'tags' => []
                    ],
                    [
                        'value' => 'nullement',
                        'tags' => []
                    ],
                    [
                        'value' => 'pas',
                        'tags' => []
                    ],
                    [
                        'value' => 'plus',
                        'tags' => []
                    ],
                    [
                        'value' => 'point',
                        'tags' => []
                    ],
                    [
                        'value' => 'prou',
                        'tags' => []
                    ],
                    [
                        'value' => 'que',
                        'tags' => []
                    ],
                    [
                        'value' => 'vraiment pas',
                        'tags' => []
                    ]
                ],
                'rules' => [],
                'tags' => []
            ],
            [
                'id' => 4,
                'code' => 'nc',
                'label' => 'nom commun',
                'words' => [
                    [
                        'value' => 'abondement',
                        'tags' => [
                            'masculin',
                            'singulier'
                        ]
                    ],
                    [
                        'value' => 'bleuet',
                        'tags' => [
                            'masculin',
                            'singulier'
                        ]
                    ],
                    [
                        'value' => 'cardinal',
                        'tags' => [
                            'masculin',
                            'singulier'
                        ]
                    ],
                    [
                        'value' => 'cardiopathie',
                        'tags' => [
                            'feminin',
                            'singulier'
                        ]
                    ],
                    [
                        'value' => 'cerceaux',
                        'tags' => [
                            'masculin',
                            'pluriel'
                        ]
                    ],
                    [
                        'value' => 'danger',
                        'tags' => [
                            'masculin',
                            'singulier'
                        ]
                    ],
                    [
                        'value' => 'délivreur',
                        'tags' => [
                            'masculin',
                            'singulier'
                        ]
                    ],
                    [
                        'value' => 'flambeau',
                        'tags' => [
                            'masculin',
                            'singulier'
                        ]
                    ],
                    [
                        'value' => 'impact',
                        'tags' => [
                            'masculin',
                            'singulier'
                        ]
                    ],
                    [
                        'value' => 'pension',
                        'tags' => [
                            'feminin',
                            'singulier'
                        ]
                    ]
                ],
                'rules' => [],
                'tags' => []
            ],
            [
                'id' => 5,
                'code' => 'np',
                'label' => 'nom propre',
                'words' => [
                    [
                        'value' => 'Acheres-la-Foret',
                        'tags' => []
                    ],
                    [
                        'value' => 'Adam',
                        'tags' => []
                    ],
                    [
                        'value' => 'Claudius',
                        'tags' => []
                    ],
                    [
                        'value' => 'Ellga',
                        'tags' => []
                    ],
                    [
                        'value' => 'Kenji',
                        'tags' => []
                    ],
                    [
                        'value' => 'Luzy-sur-Marne',
                        'tags' => []
                    ],
                    [
                        'value' => 'Mozelle',
                        'tags' => []
                    ],
                    [
                        'value' => 'Razimet',
                        'tags' => []
                    ],
                    [
                        'value' => 'Saint-Pierre-sur-Doux',
                        'tags' => []
                    ],
                    [
                        'value' => 'St-Briac-sur-Mer',
                        'tags' => []
                    ],
                    [
                        'value' => 'Thiezac',
                        'tags' => []
                    ]
                ],
                'rules' => [],
                'tags' => []
            ],
            [
                'id' => 6,
                'code' => 'prep',
                'label' => 'locution prépositive',
                'words' => [
                    [
                        'id' => 12,
                        'value' => 'afin de',
                        'tags' => []
                    ],
                    [
                        'id' => 13,
                        'value' => 'à moins de',
                        'tags' => []
                    ],
                    [
                        'id' => 14,
                        'value' => 'de façon à',
                        'tags' => []
                    ],
                    [
                        'id' => 15,
                        'value' => 'par suite de',
                        'tags' => []
                    ],
                    [
                        'id' => 16,
                        'value' => 'au sein de',
                        'tags' => []
                    ],
                    [
                        'id' => 17,
                        'value' => 'de part et d\'autre de',
                        'tags' => []
                    ],
                    [
                        'id' => 18,
                        'value' => 'en absence de',
                        'tags' => []
                    ]
                ],
                'rules' => [],
                'tags' => []
            ],
            [
                'id' => 7,
                'code' => 'v',
                'label' => 'verbe',
                'words' => [
                    [
                        'id' => 1,
                        'value' => 'couper',
                        'tags' => ['groupe1']
                    ],
                    [
                        'id' => 2,
                        'value' => 'crier',
                        'tags' => ['groupe1']
                    ],
                    [
                        'id' => 3,
                        'value' => 'dégainer',
                        'tags' => ['groupe1']
                    ],
                    [
                        'id' => 4,
                        'value' => 'abolir',
                        'tags' => ['groupe2']
                    ],
                    [
                        'id' => 5,
                        'value' => 'bâtir',
                        'tags' => ['groupe2']
                    ],
                    [
                        'id' => 6,
                        'value' => 'applaudir',
                        'tags' => ['groupe2']
                    ],
                    [
                        'id' => 7,
                        'value' => 'ouvrir',
                        'tags' => ['groupe3']
                    ],
                    [
                        'id' => 8,
                        'value' => 'pouvoir',
                        'tags' => ['groupe3']
                    ],
                    [
                        'id' => 9,
                        'value' => 'vaincre',
                        'tags' => ['groupe3']
                    ],
                    [
                        'id' => 10,
                        'value' => 'vouloir',
                        'tags' => ['groupe3']
                    ],
                    [
                        'id' => 11,
                        'value' => 'mordre',
                        'tags' => ['groupe3']
                    ]
                ],
                'rules' => [
                    [
                        'level' => 0,
                        'tagWord' => ['couper'],
                        'tagCategory' => [],
                        'result' => "coup",
                    ],
                    [
                        'level' => 0,
                        'tagWord' => ['crier'],
                        'tagCategory' => [],
                        'result' => "cri",
                    ],
                    [
                        'level' => 0,
                        'tagWord' => ['dégainer'],
                        'tagCategory' => [],
                        'result' => "dégain",
                    ],
                    [
                        'level' => 0,
                        'tagWord' => ['abolir'],
                        'tagCategory' => [],
                        'result' => "abol",
                    ],
                    [
                        'level' => 0,
                        'tagWord' => ['bâtir'],
                        'tagCategory' => [],
                        'result' => "bât",
                    ],
                    [
                        'level' => 0,
                        'tagWord' => ['applaudir'],
                        'tagCategory' => [],
                        'result' => "applaud",
                    ],
                    /**********************/
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["present", "indicatif", "1ps"],
                        'result' => "{word}e",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["present", "indicatif", "2ps"],
                        'result' => "{word}es",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["present", "indicatif", "3ps"],
                        'result' => "{word}e",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["present", "indicatif", "1pp"],
                        'result' => "{word}ons",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["present", "indicatif", "2pp"],
                        'result' => "{word}ez",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["present", "indicatif", "3pp"],
                        'result' => "{word}ent",
                    ],
                    /******************/
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["present", "indicatif", "1ps"],
                        'result' => "{word}is",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["present", "indicatif", "2ps"],
                        'result' => "{word}is",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["present", "indicatif", "3ps"],
                        'result' => "{word}it",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["present", "indicatif", "1pp"],
                        'result' => "{word}issons",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["present", "indicatif", "2pp"],
                        'result' => "{word}issez",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["present", "indicatif", "3pp"],
                        'result' => "{word}issent",
                    ],
                    /******************/
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["imparfait", "1ps"],
                        'result' => "{word}ais",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["imparfait", "2ps"],
                        'result' => "{word}ais",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["imparfait", "3ps"],
                        'result' => "{word}ait",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["imparfait", "1pp"],
                        'result' => "{word}ions",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["imparfait", "2pp"],
                        'result' => "{word}iez",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe1'],
                        'tagCategory' => ["imparfait", "3pp"],
                        'result' => "{word}aient",
                    ],
                    /******************/
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["imparfait", "1ps"],
                        'result' => "{word}issais",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["imparfait", "2ps"],
                        'result' => "{word}issais",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["imparfait", "3ps"],
                        'result' => "{word}issait",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["imparfait", "1pp"],
                        'result' => "{word}issions",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["imparfait", "2pp"],
                        'result' => "{word}issiez",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['groupe2'],
                        'tagCategory' => ["imparfait", "3pp"],
                        'result' => "{word}issaient",
                    ],
                ],
                'tags' => [
                    ['present', 'indicatif', '1ps'],
                    ['present', 'indicatif', '2ps'],
                    ['present', 'indicatif', '3ps'],
                    ['present', 'indicatif', '1pp'],
                    ['present', 'indicatif', '2pp'],
                    ['present', 'indicatif', '3pp'],
                    ['imparfait', '1ps'],
                    ['imparfait', '2ps'],
                    ['imparfait', '3ps'],
                    ['imparfait', '1pp'],
                    ['imparfait', '2pp'],
                    ['imparfait', '3pp'],
                ]
            ],
            [
                'id' => 8,
                'code' => 'persian',
                'label' => 'mots perses',
                'words' => [
                    [
                        'id' => '100',
                        'value' => 'xaridan',
                        'tags' => []
                    ]
                ],
                'rules' => [
                    [
                        'level' => 0,
                        'tagWord' => ['xaridan'],
                        'tagCategory' => [],
                        'result' => "xar",
                    ],
                    [
                        'level' => 0,
                        'tagWord' => ['xaridan'],
                        'tagCategory' => ["pst"],
                        'result' => "xarid",
                    ],
                    [
                        'level' => 1,
                        'tagWord' => ['xaridan'],
                        'tagCategory' => ["ind", "ipfv"],
                        'result' => "mi{word}",
                    ],
                    [
                        'level' => 2,
                        'tagWord' => ['xaridan'],
                        'tagCategory' => ['neg'],
                        'result' => "na{word}",
                    ],
                    [
                        'level' => 2,
                        'tagWord' => ['xaridan'],
                        'tagCategory' => ['ind', 'ipfv', 'neg'],
                        'result' => "ne{word}",
                    ],
                    [
                        'level' => 3,
                        'tagWord' => ['xaridan'],
                        'tagCategory' => ['evind'],
                        'result' => "{word}e",
                    ],
                    [
                        'level' => 4,
                        'tagWord' => ['xaridan'],
                        'tagCategory' => ['1sg'],
                        'result' => "{word}am",
                    ],
                    [
                        'level' => 4,
                        'tagWord' => ['xaridan'],
                        'tagCategory' => ['2sg'],
                        'result' => "{word}i",
                    ],
                    [
                        'level' => 4,
                        'tagWord' => ['xaridan'],
                        'tagCategory' => ['prs', '3sg'],
                        'result' => "{word}ad",
                    ],
                    [
                        'level' => 4,
                        'tagWord' => ['xaridan'],
                        'tagCategory' => ['evind', '3sg'],
                        'result' => "{word}ast"
                    ]
                ],
                'tags' => [
                    ['ind', 'pst', 'evdir', 'ipfv', 'neg', '3sg'],
                    ['ind', 'pst', 'pfv', 'evind', 'nonprf', 'neg', '3sg'],
                ]
            ]
        ];
        return $data;
    }

    /**
     * Chargement des données en base
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categories = $this->getData();

        // Pour chaque catégorie...
        foreach ($categories as $item) {
            $category = new Category();
            $category->setId($item['id']);
            $category->setCode($item['code']);
            $category->setName($item['label']);
            $manager->persist($category);
            $metadata = $manager->getClassMetaData(get_class($category));
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

            // ... On ajoute les mots de la catégorie...
            foreach ($item['words'] as $wordData) {
                $word = new Word();
                if(isset($wordData['id'])) {
                    $word->setId($wordData['id']);
                }
                $word->setValue($wordData['value']);
                $word->setCategory($category);
                $word->setTags(implode(";", $wordData['tags']));
                $manager->persist($word);

                // Enforce specified record ID
                $metadata = $manager->getClassMetaData(get_class($word));
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            }

            // ... Puis les règle de cette catégorie...
            foreach ($item['rules'] as $PFMdata) {
                $rule = new PFMRule();
                $rule->setCategory($category);
                $rule->setApplicationLevel($PFMdata['level']);
                $rule->setTagWord(implode(";", $PFMdata['tagWord']));
                $rule->setTagCategory(implode(";", $PFMdata['tagCategory']));
                $rule->setResult($PFMdata['result']);
                $manager->persist($rule);
            }

            // ... et enfin les associations de tags
            foreach ($item['tags'] as $tagC) {
                $tagCat = new TagAssociation();
                $tagCat->setCombination(implode(";", $tagC));
                $tagCat->setCategory($category);
                $manager->persist($tagCat);
            }
        }
        $manager->flush();
    }
}
