<?php

namespace MyShopKitPopupSmartBarSlideIn\Insight\Shared\LastWeek;

use MyShopKitPopupSmartBarSlideIn\Insight\Shared\Query\QueryBuilder;
use MyShopKitPopupSmartBarSlideIn\Insight\Shared\TraitJoinPost;

class LastWeekQuery extends QueryBuilder {
	use TraitJoinPost;

	public function select(): QueryBuilder {
		$this->setWhat()->setWhere()->setJoin();
		$this->groupBy = "date";

		return $this;
	}

	public function setWhat(): QueryBuilder {
		$this->aSelectWhat[] = "DATE(createdDate) as date";

		return $this;
	}

	public function setWhere(): QueryBuilder {
		$this->aWhere[] = '(YEARWEEK(createdDate,7) = YEARWEEK(CURDATE(),7)-1)';

		return $this;
	}
}
