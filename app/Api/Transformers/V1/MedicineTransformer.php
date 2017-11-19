<?php

namespace App\Api\Transformers\V1;

use App\Api\Transformers\Transformer;

class MedicineTransformer extends Transformer
{
    /**
     * @property string imageUploadedPath
     */
//    protected $imageUploadedPath;
    protected $pharmaceuticalTransformer;

    /**
     * MedicineTransformer constructor.
     */
    public function __construct(PharmaceuticalCompanyTransformer $pharmaceuticalTransformer)
    {
//        $this->imageUploadedPath  = $this->getImageRootPath() . topicImagePath();
        $this->pharmaceuticalTransformer = $pharmaceuticalTransformer;
    }

    public function transform($medicine) {

        return [
            'id'                       => $medicine->id,
            'code'                     => $medicine->code,
            'name'                     => $medicine->name,
            'description'              => $this->formatHtml($medicine->description),
            'strength'                 => trim($medicine->strength),
            'indications'              => trim($medicine->indications_details),
//            'image_path'        => ($medicine->image_path != null) ? $this->imageUploadedPath . $medicine->image_path : null,
            'administration'           => $medicine->administration,
            'ingredients'              => $medicine->ingredients,
            'contraindications'        => $medicine->contraindications,
            'sideEffects'              => $medicine->side_effects,
            'precautions'              => $medicine->precautions,
            'pregnancyCategory'        => $medicine->pregnancy_category,
            'modeOfActions'            => $medicine->mode_of_actions,
            'interactions'             => $medicine->interactions,
            'genericName'              => $medicine->generic_name,
            'medicineType'             => $medicine->medicine_type_name,
            'therapeuticClass'         => $medicine->therapeutic_class_names,
            'pharmaceuticalCompany'    => $this->getPharmaceuticalInfo($medicine->pharmaceutical),
            'packetInfo'               => $this->getPacketInfo($medicine->pack_size, $medicine->no_per_unit, $medicine->unit_price, $medicine->currency),
            'dosageInfo'               => $this->getDoseInfo($medicine->adult_dose, $medicine->child_dose, $medicine->renal_dose),
            'indicationsKeywords'      => $this->getKeyWords($medicine->indications_keywords)
            //            'sortOrder'        => $pharmaceutical->sort_order
        ];
    }

    public function metadata($collection = null)
    {
        if($collection != null) {
            return [
                'totalResult'  => count($collection),
            ];
        }
        return [];
    }

    public function getPharmaceuticalInfo($pharma) {
        if($pharma == null) {
            $pharmaceutical = null;
        } else {
            $pharmaceutical = $this->pharmaceuticalTransformer->transform($pharma);
        }

        return $pharmaceutical;
    }

    public function getDoseInfo($adultDose, $childDose, $renalDose) {
        $doseInfoArray = [
            'adult_dose'        => $adultDose,
            'child_dose'        => $childDose,
            'renal_dose'        => $renalDose
        ];

        return $doseInfoArray;
    }

    public function getPacketInfo($packSize, $noPerUnit, $unitPrice, $currency) {
        $packetInfoArray = [
            'pack_size'         => $packSize,
            'no_per_unit'       => $noPerUnit,
            'unit_price'        => $unitPrice,
            'currency'          => $currency
        ];

        return $packetInfoArray;
    }

    public function getKeyWords($keyWords) {
        if($keyWords !== null) {
            $keyWords = explode(',', $keyWords);
        }

        return $keyWords;
    }

    public function getTherapeuticClass($keyWords) {
        if($keyWords !== null) {
            $keyWords = explode(',', $keyWords);
        }

        return $keyWords;
    }
}
