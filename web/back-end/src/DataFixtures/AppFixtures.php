<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\PFMRule;
use App\Entity\TagAssociation;
use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

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
                'code' => 'prep',
                'label' => 'locution prépositive',
                'words' => [
                    [
                        'value' => 'afin de',
                        'tags' => []
                    ],
                    [
                        'value' => 'à moins de',
                        'tags' => []
                    ],
                    [
                        'value' => 'de façon à',
                        'tags' => []
                    ],
                    [
                        'value' => 'par suite de',
                        'tags' => []
                    ],
                    [
                        'value' => 'au sein de',
                        'tags' => []
                    ],
                    [
                        'value' => 'de part et d\'autre de',
                        'tags' => []
                    ],
                    [
                        'value' => 'en absence de',
                        'tags' => []
                    ]
                ],
                'rules' => [],
                'tags' => []
            ],
            [
                'code' => 'v',
                'label' => 'verbe',
                'words' => [
                    [
                        'value' => 'couper',
                        'tags' => ['groupe1']
                    ],
                    [
                        'value' => 'crier',
                        'tags' => ['groupe1']
                    ],
                    [
                        'value' => 'dégainer',
                        'tags' => ['groupe1']
                    ],
                    [
                        'value' => 'abolir',
                        'tags' => ['groupe2']
                    ],
                    [
                        'value' => 'bâtir',
                        'tags' => ['groupe2']
                    ],
                    [
                        'value' => 'applaudir',
                        'tags' => ['groupe2']
                    ],
                    [
                        'value' => 'ouvrir',
                        'tags' => ['groupe3']
                    ],
                    [
                        'value' => 'pouvoir',
                        'tags' => ['groupe3']
                    ],
                    [
                        'value' => 'vaincre',
                        'tags' => ['groupe3']
                    ],
                    [
                        'value' => 'vouloir',
                        'tags' => ['groupe3']
                    ],
                    [
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
                'code' => 'persian',
                'label' => 'mots perses',
                'words' => [
                    [
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
            $category->setCode($item['code']);
            $category->setName($item['label']);
            $manager->persist($category);

            // ... On ajoute les mots de la catégorie...
            foreach ($item['words'] as $wordData) {
                $word = new Word();
                $word->setValue($wordData['value']);
                $word->setCategory($category);
                $word->setTags(implode(";", $wordData['tags']));
                $manager->persist($word);
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
