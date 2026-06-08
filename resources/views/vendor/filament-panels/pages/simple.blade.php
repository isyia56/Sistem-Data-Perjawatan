<x-filament-panels::page.simple>
    <style>
        .fi-simple-layout {
            background-color: #fff7ed !important;
            min-height: 100vh !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .fi-simple-main {
            background-color: #fcecd8 !important;
            border: 3px solid #f97316 !important;
            border-radius: 18px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12) !important;            padding: 20px 32px !important;
            width: 100% !important;
            max-width: 450px !important;
        }

        .fi-simple-header {
            display: none !important;
        }

        .fi-simple-main > div:first-child {
            margin-bottom: 0 !important;
        }

        /* Labels */
        .fi-fo-field-label,
        label {
            color: #7c3a00 !important;
            font-weight: 600 !important;
        }

        /* Input Wrapper */
        .fi-input-wrp {
            background-color: #fff7ed !important;
            border: 1px solid #fdba74 !important;
            border-radius: 10px !important;
        }

        .fi-input-wrp:focus-within {
            border-color: #f97316 !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15) !important;
        }

        /* Input */
        .fi-input-wrp input {
            background: transparent !important;
            color: #7c3a00 !important;
        }

        .fi-input-wrp input::placeholder {
            color: #b45309 !important;
        }

        /* Login Button */
        .fi-btn {
            background-color: #ea580c !important;
            color: white !important;
            border-radius: 9999px !important;
            font-weight: 600 !important;
        }

        .fi-btn:hover {
            background-color: #c2410c !important;
        }

        /* Checkbox */
        .fi-checkbox-label {
            color: #7c3a00 !important;
        }

        .fi-checkbox-input {
            accent-color: #f97316 !important;
        }

        /* Remove extra spacing */
        .fi-form {
            gap: 0.75rem !important;
        }
    </style>

    {{-- Custom Header --}}
    <div
        style="
            text-align:center;
            margin-bottom:18px;
            display:flex;
            flex-direction:column;
            align-items:center;
        "
    >
        <img
            src="{{ asset('images/logo.png') }}"
            alt="e-SDaP Logo"
            style="
                width:200px;
                height: 200px;
                object-fit:contain;
                margin-bottom:8px;
            "
        >

        <h1
            style="
                font-size:32px;
                font-weight:700;
                color:#c2410c;
                margin:0;
                line-height:1.2;
            "
        >
            Sistem Perjawatan
        </h1>

        <p
            style="
                font-size:14px;
                color:#92400e;
                margin-top:8px;
            "
        >
            Sila log masuk untuk meneruskan
        </p>
    </div>

    {{ $this->content }}

</x-filament-panels::page.simple>