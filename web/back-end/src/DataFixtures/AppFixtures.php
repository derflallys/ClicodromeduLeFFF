<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\PFMRule;
use App\Entity\TagAssociation;
use App\Entity\TagCategory;
use App\Entity\TagWord;
use App\Entity\Word;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;

class AppFixtures extends Fixture
{
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
                'rules' => [],
                'tags' => []
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
    public function load(ObjectManager $manager)
    {
        $categories = $this->getData();

        foreach ($categories as $item) {
            $category = new Category();
            $category->setCode($item['code']);
            $category->setName($item['label']);
            $manager->persist($category);

            foreach ($item['words'] as $wordData) {
                $word = new Word();
                $word->setValue($wordData['value']);
                $word->setCategory($category);
                $word->setTags(implode(";", $wordData['tags']));
                $manager->persist($word);
            }

            foreach ($item['rules'] as $PFMdata) {
                $rule = new PFMRule();
                $rule->setCategory($category);
                $rule->setApplicationLevel($PFMdata['level']);
                $rule->setTagWord(implode(";", $PFMdata['tagWord']));
                $rule->setTagCategory(implode(";", $PFMdata['tagCategory']));
                $rule->setResult($PFMdata['result']);
                $manager->persist($rule);
            }

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
