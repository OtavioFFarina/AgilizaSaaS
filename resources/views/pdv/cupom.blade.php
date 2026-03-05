<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cupom #{{ $venda->id }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('assets/img/site.webmanifest') }}">

    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .cupom {
            width: 300px;
            background-color: #fff9c4;
            padding: 15px;
            margin: 0 auto;
            border: 1px dashed #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .divisor {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .btn-print {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background: #000;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .cupom {
                box-shadow: none;
                border: none;
                width: 100%;
                margin: 0;
                background-color: white;
            }

            .btn-print,
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="cupom">
        <div class="text-center">
            <h3 style="margin: 0;">{{ strtoupper($nomeEstabelecimento) }}</h3>
            <small>Sistema PDV Agiliza</small><br>
            <small>{{ $venda->created_at->format('d/m/Y H:i') }}</small>
        </div>

        <div class="divisor"></div>

        <div class="text-center fw-bold" style="margin-bottom: 5px;">CUPOM NÃO FISCAL</div>
        <div class="text-center">Venda Nº: #{{ str_pad($venda->id, 6, '0', STR_PAD_LEFT) }}</div>

        <div class="divisor"></div>

        @foreach ($venda->itens as $item)
            @php
                $subtotal = $item->quantidade * $item->preco_unitario;
            @endphp
            <div class="item-row">
                <div style="flex: 2;">
                    {{ $item->quantidade }}x {{ $item->produto->nome ?? 'Produto' }}
                    {{ $item->produto->sabor ?? '' }}
                </div>
                <div style="flex: 1;" class="text-right">
                    R$ {{ number_format($subtotal, 2, ',', '.') }}
                </div>
            </div>
        @endforeach

        <div class="divisor"></div>

        <div class="item-row fw-bold" style="font-size: 16px;">
            <span>TOTAL A PAGAR</span>
            <span>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</span>
        </div>

        <div class="item-row" style="margin-top: 5px;">
            <span>Forma de Pagamento:</span>
            <span>{{ strtoupper($venda->forma_pagamento) }}</span>
        </div>

        <div class="divisor"></div>
        <div class="text-center">
            <small>Obrigado pela preferência!</small><br>
            <small>Volte sempre! 🍦</small>
        </div>

        <button class="btn-print" onclick="window.print()">IMPRIMIR AGORA</button>
    </div>

    <script>
        window.onload = function () {
            setTimeout(() => {
                window.print();
            }, 500);
        }
    </script>

</body>

</html>