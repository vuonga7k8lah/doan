<?php

namespace HSSC\Illuminate\Query;

interface IQueryBuilder
{
	public function setRawArgs(array $aRawArgs): IQueryBuilder;

	public function parseArgs(): IQueryBuilder;

	public function getArgs(): array;
}
