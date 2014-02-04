<?php

namespace app\ariad\helpers;

class Form 
{

	/**
	 * Gets currently assign values to a multi form element
	 */
	public function assignedIDs($model)
	{
		if(is_null($model))
			return array();
		$assignedValues = array();
		foreach ($model as $value)
		{
			$assignedValues[] = $value->id;
		}

		return $assignedValues;
	}

	/**
	 *	Update a multiselect be selecting/deselecting values
	 *
	 * @param $model object primary model
	 * @param $selectArr array of curently selected values
	 * @param $methodName string name of method in model for belongsToMany relation
	 * @param $allElems array of all elements in the select
	 * @param $assignedElems array of all currently assigned elements 
	 **/
	public function updateMultiSelect($model, $selectArr, $methodName, $allElems, $assignedElems)
	{
		foreach ($allElems as $id => $name)
		{
			// Is this ID currently assigned in the DB and has it been submitted
			if(!in_array($id, $assignedElems) && in_array($id, $selectArr))
				$model->$methodName()->attach($id);

			// Is this id not being posted? If so remove it
			elseif(!in_array($id, $selectArr))
				$model->$methodName()->detach($id);
		}
	}
}