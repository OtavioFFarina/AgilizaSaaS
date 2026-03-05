<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $estabelecimento_id
 * @property int $plano_id
 * @property string $status
 * @property string|null $data_vencimento
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assinatura newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assinatura newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assinatura query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assinatura whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assinatura whereDataVencimento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assinatura whereEstabelecimentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assinatura whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assinatura wherePlanoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assinatura whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assinatura whereUpdatedAt($value)
 */
	class Assinatura extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $estabelecimento_id
 * @property int $user_id
 * @property string $status
 * @property numeric $valor_abertura
 * @property numeric|null $valor_fechamento
 * @property string $data_abertura
 * @property string|null $data_fechamento
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa whereDataAbertura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa whereDataFechamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa whereEstabelecimentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa whereValorAbertura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Caixa whereValorFechamento($value)
 */
	class Caixa extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $estabelecimento_id
 * @property string $nome
 * @property int $ativo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereAtivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereEstabelecimentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Categoria whereUpdatedAt($value)
 */
	class Categoria extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $id
 * @property string|null $cnpj
 * @property string $nome_fantasia
 * @property int $ativo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento whereAtivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento whereCnpj($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento whereNomeFantasia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Estabelecimento withoutTrashed()
 */
	class Estabelecimento extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nome
 * @property string $codigo_slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modulo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modulo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modulo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modulo whereCodigoSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modulo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modulo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modulo whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Modulo whereUpdatedAt($value)
 */
	class Modulo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nome
 * @property numeric $preco_mensal
 * @property int $ativo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plano newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plano newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plano query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plano whereAtivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plano whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plano whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plano whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plano whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plano wherePrecoMensal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plano whereUpdatedAt($value)
 */
	class Plano extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $estabelecimento_id
 * @property int $categoria_id
 * @property string $nome
 * @property string|null $sabor
 * @property numeric $preco_venda
 * @property numeric $preco_compra
 * @property int $ativo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto whereAtivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto whereCategoriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto whereEstabelecimentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto wherePrecoCompra($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto wherePrecoVenda($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto whereSabor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Produto whereUpdatedAt($value)
 */
	class Produto extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $estabelecimento_id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEstabelecimentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $estabelecimento_id
 * @property int|null $caixa_id
 * @property int $user_id
 * @property numeric $valor_total
 * @property string|null $forma_pagamento
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda whereCaixaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda whereEstabelecimentoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda whereFormaPagamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venda whereValorTotal($value)
 */
	class Venda extends \Eloquent {}
}

