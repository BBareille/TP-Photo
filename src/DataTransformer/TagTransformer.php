<?php

namespace App\DataTransformer;

use App\Entity\Tags;
use App\Repository\TagsRepository;
use Symfony\Component\Form\DataTransformerInterface;

class TagTransformer implements DataTransformerInterface
{
    public function __construct(public TagsRepository $tagsRepository){

    }


    public function transform(mixed $value)
    {
        $tagList = '';
        /** @var Tags $tag */
        foreach ($value as $tag){
            $tagList .= $tag->getName(). ', ';
        }

        return $tagList;
    }

    public function reverseTransform(mixed $value)
    {

        if(!$value){
            return null;
        }

        $value = explode(',',$value);

        $tags = array_map(function ($tag) {
            $findTag = $this->tagsRepository->findOneBy(['name'=>trim($tag)]);
            if(!$findTag) {
                $newTag = new Tags();
                $newTag->setName(trim($tag));
                return $newTag;
            }
            return $findTag;
        },$value);

        return $tags;
    }
}