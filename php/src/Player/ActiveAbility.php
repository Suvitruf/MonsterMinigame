<?php
namespace SteamDB\CTowerAttack\Player;

use SteamDB\CTowerAttack\Enums;
use SteamDB\CTowerAttack\Server;

class ActiveAbility
{
	/*
	optional uint32 ability = 1;
	optional uint32 timestamp_done = 2;
	optional uint32 timestamp_cooldown = 3;
	*/
	private $Ability;
	private $TimestampDone;
	private $TimestampCooldown;

	public function __construct( $Ability )
	{
		$this->Ability = $Ability;
		$this->TimestampDone = time() + $this->GetDuration();
		$this->TimestampCooldown = time() + $this->GetCooldown();
	}

	public function ToArray()
	{
		return [
			'ability' => $this->Ability,
			'timestamp_done' => $this->TimestampDone,
			'timestamp_cooldown' => $this->TimestampCooldown
		];
	}

	public function GetAbility()
	{
		return $this->Ability;
	}

	public function GetTimestampDone()
	{
		return $this->TimestampDone;
	}

	public function IsDone()
	{
		return $this->TimestampDone <= time();
	}

	public function GetTimestampCooldown()
	{
		return $this->TimestampCooldown;
	}

	public function IsCooledDown()
	{
		return $this->TimestampCooldown <= time();
	}

	public function GetName()
	{
		return $this->GetAbilityTuningData( 'name' );
	}

	public function GetMaxNumClicks()
	{
		return $this->GetAbilityTuningData( 'max_num_clicks' );
	}

	public function GetMultiplier()
	{
		return $this->GetAbilityTuningData( 'multiplier' );
	}

	public function GetCost()
	{
		return $this->GetAbilityTuningData( 'cost' );
	}

	public function GetDuration()
	{
		return $this->GetAbilityTuningData( 'duration' );
	}

	public function GetCooldown()
	{
		return $this->GetAbilityTuningData( 'cooldown' );
	}

	public function GetDescription()
	{
		return $this->GetAbilityTuningData( 'desc' );
	}

	public function IsInstant()
	{
		return $this->GetAbilityTuningData( 'instant' ) === 1;
	}

	public function GetBadgePointCost()
	{
		return $this->GetAbilityTuningData( 'badge_points_cost' );
	}

	private function GetAbilityTuningData( $Key = null )
	{
		return self::GetTuningData( $this->Ability, $Key );
	}

	public static function GetTuningData( $Ability, $Key = null )
	{
		$TuningData = Server::GetTuningData( 'abilities' );
		if( $Key === null ) 
		{
			return $TuningData[ $Ability ];
		} 
		else if( !array_key_exists( $Key, $TuningData[ $Ability ] ) ) 
		{
			return null;
		}
		return $TuningData[ $Ability ][ $Key ];
	}
}