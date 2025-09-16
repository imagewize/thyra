<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class ExpertiseDetailAdvantages extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $advantages = Builder::make('expertise_detail_advantages');

        $advantages
            ->setLocation('block', '==', 'acf/expertise-detail-advantages');

        $advantages
            ->addText('advantages_pill_text', [
                'label' => 'Pill Text',
                'default_value' => 'Benefits',
                'instructions' => 'Text for the blue pill tag (e.g., "Benefits")'
            ])
            ->addText('advantages_main_title', [
                'label' => 'Main Title',
                'default_value' => 'What benefits do our services provide',
                'instructions' => 'Main section heading'
            ])
            ->addTextarea('advantages_description', [
                'label' => 'Description',
                'default_value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
                'instructions' => 'Description text below the main title'
            ])
            ->addRepeater('advantages_list', [
                'label' => 'Advantages List',
                'min' => 1,
                'max' => 6,
                'layout' => 'block',
                'button_label' => 'Add Advantage'
            ])
                ->addText('title', [
                    'label' => 'Advantage Title',
                    'required' => 0,
                    'default_value' => 'Advantage Title'
                ])
                ->addTextarea('description', [
                    'label' => 'Advantage Description',
                    'required' => 0,
                    'default_value' => 'Description of this advantage...'
                ])
                ->addSelect('icon_type', [
                    'label' => 'Icon Type',
                    'choices' => [
                        'checkmark' => 'Checkmark',
                        'star' => 'Star',
                        'arrow' => 'Arrow'
                    ],
                    'default_value' => 'checkmark'
                ])
            ->endRepeater();

        return $advantages->build();
    }
}
