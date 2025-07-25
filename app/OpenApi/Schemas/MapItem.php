<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="MapItem",
 *     type="object",
 *     title="Map Item",
 *     description="Map Item model",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="floor", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Room A101"),
 *     @OA\Property(property="description", type="string", example="Meeting Room"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class MapItem
{
}