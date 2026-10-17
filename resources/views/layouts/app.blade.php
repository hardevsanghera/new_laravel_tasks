<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0b1f33">

    <title>@yield('title', 'Task Manager')</title>

    <style>
        :root {
            color-scheme: dark;
            --ink: #f4f8fc;
            --muted: #b8c8d9;
            --navy: #0b1f33;
            --navy-deep: #071521;
            --blue: #2f7cf6;
            --cyan: #55d4f4;
            --teal: #89e1d0;
            --line: rgba(197, 222, 244, 0.2);
            --glow: rgba(47, 124, 246, 0.32);
            --surface: rgba(255, 255, 255, 0.08);
            --surface-strong: rgba(255, 255, 255, 0.13);
            --shadow: 0 24px 70px rgba(0, 0, 0, 0.3);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            margin: 0;
            color: var(--ink);
            background: var(--navy-deep);
            font-family: "Nutanix Sans", "Avenir Next", "Segoe UI", Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        button,
        input {
            font: inherit;
        }

        .page {
            position: relative;
            min-height: 100vh;
            isolation: isolate;
            overflow: hidden;
            background:
                radial-gradient(circle at 77% 16%, var(--glow), transparent 24rem),
                linear-gradient(135deg, var(--navy-deep) 0%, var(--navy) 55%, #0c2a49 100%);
        }

        .page::before,
        .page::after {
            position: absolute;
            z-index: -1;
            border: 1px solid var(--line);
            border-radius: 999px;
            content: "";
            pointer-events: none;
            transform: rotate(-24deg);
        }

        .page::before {
            right: -12rem;
            bottom: 7rem;
            width: 48rem;
            height: 19rem;
            box-shadow: 0 0 0 1.25rem rgba(85, 212, 244, 0.04), 0 0 0 2.5rem rgba(85, 212, 244, 0.025);
        }

        .page::after {
            top: 9rem;
            left: -16rem;
            width: 33rem;
            height: 13rem;
            border-color: rgba(137, 225, 208, 0.18);
        }

        .shell {
            width: min(100% - 48px, 1000px);
            min-height: 100vh;
            margin: 0 auto;
            padding: 30px 0 28px;
            display: flex;
            flex-direction: column;
        }

        .brandbar,
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            animation: rise-in 700ms ease-out both;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            color: var(--ink);
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-decoration: none;
            text-transform: uppercase;
        }

        .brand-mark {
            position: relative;
            display: inline-block;
            width: 24px;
            height: 24px;
        }

        .brand-mark::before,
        .brand-mark::after {
            position: absolute;
            border: 3px solid var(--cyan);
            border-radius: 50%;
            content: "";
            transform: rotate(30deg);
        }

        .brand-mark::before {
            inset: 2px 8px 2px 0;
        }

        .brand-mark::after {
            inset: 2px 0 2px 8px;
            border-color: var(--blue);
        }

        .eyebrow {
            margin: 0;
            color: var(--teal);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .hero {
            padding: 58px 0 42px;
            animation: rise-in 800ms 100ms ease-out both;
        }

        h1 {
            max-width: 760px;
            margin: 16px 0 16px;
            font-size: clamp(3rem, 8vw, 5.5rem);
            line-height: 0.98;
            letter-spacing: -0.075em;
            font-weight: 700;
        }

        h1 span {
            color: var(--cyan);
        }

        .lede {
            max-width: 610px;
            margin: 0;
            color: var(--muted);
            font-size: clamp(1rem, 1.8vw, 1.15rem);
            line-height: 1.65;
        }

        .workspace {
            display: grid;
            grid-template-columns: minmax(250px, 0.8fr) minmax(0, 1.2fr);
            gap: 18px;
            align-items: start;
            animation: rise-in 800ms 160ms ease-out both;
        }

        .panel {
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: var(--surface);
            box-shadow: var(--shadow);
            backdrop-filter: blur(12px);
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 19px 21px;
            border-bottom: 1px solid var(--line);
        }

        .panel-heading h2 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        .panel-heading p {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .panel-body {
            padding: 21px;
        }

        .field-label {
            display: block;
            margin-bottom: 8px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        .task-input {
            width: 100%;
            min-height: 46px;
            padding: 11px 13px;
            border: 1px solid var(--line);
            border-radius: 9px;
            outline: none;
            color: var(--ink);
            background: rgba(7, 21, 33, 0.58);
            transition: border-color 160ms ease, box-shadow 160ms ease;
        }

        .task-input::placeholder {
            color: #8298ad;
        }

        .task-input:focus {
            border-color: var(--cyan);
            box-shadow: 0 0 0 3px rgba(85, 212, 244, 0.14);
        }

        .button {
            display: inline-flex;
            min-height: 42px;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border: 1px solid transparent;
            border-radius: 9px;
            color: #071521;
            background: linear-gradient(105deg, var(--cyan), var(--teal));
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: filter 160ms ease, transform 160ms ease;
        }

        .button:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        .button:focus-visible,
        .delete-button:focus-visible,
        .brand:focus-visible {
            outline: 2px solid var(--cyan);
            outline-offset: 3px;
        }

        .add-button {
            width: 100%;
            margin-top: 13px;
        }

        .alert {
            margin-bottom: 16px;
            padding: 12px 14px;
            border: 1px solid rgba(255, 150, 150, 0.35);
            border-radius: 9px;
            color: #ffd0d0;
            background: rgba(140, 36, 50, 0.2);
            font-size: 13px;
        }

        .alert strong {
            display: block;
            margin-bottom: 6px;
        }

        .alert ul {
            margin: 0;
            padding-left: 18px;
        }

        .count {
            display: inline-flex;
            min-width: 28px;
            height: 28px;
            justify-content: center;
            align-items: center;
            padding: 0 8px;
            border: 1px solid var(--line);
            border-radius: 999px;
            color: var(--cyan);
            background: var(--surface);
            font-size: 12px;
            font-weight: 700;
        }

        .task-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 15px 21px;
            border-bottom: 1px solid rgba(197, 222, 244, 0.12);
        }

        .task-item:last-child {
            border-bottom: 0;
        }

        .task-name {
            min-width: 0;
            overflow-wrap: anywhere;
            color: var(--ink);
            font-size: 14px;
            line-height: 1.5;
        }

        .delete-button {
            flex: 0 0 auto;
            padding: 7px 10px;
            border: 1px solid var(--line);
            border-radius: 8px;
            color: var(--muted);
            background: transparent;
            font-size: 12px;
            cursor: pointer;
            transition: color 160ms ease, border-color 160ms ease, background 160ms ease;
        }

        .delete-button:hover {
            border-color: rgba(255, 150, 150, 0.5);
            color: #ffd0d0;
            background: rgba(140, 36, 50, 0.2);
        }

        .empty-state {
            padding: 28px 21px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .footer {
            align-items: end;
            gap: 24px;
            margin-top: auto;
            padding-top: 24px;
            animation-delay: 220ms;
        }

        .footer-note {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
        }

        .footer-words {
            display: flex;
            justify-content: end;
            gap: 10px;
            flex-wrap: wrap;
        }

        .footer-words span {
            padding: 8px 11px;
            border: 1px solid var(--line);
            border-radius: 999px;
            color: var(--muted);
            background: var(--surface);
            font-size: 11px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        @keyframes rise-in {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 700px) {
            .shell {
                width: min(100% - 32px, 560px);
                padding-top: 22px;
            }

            .brandbar {
                align-items: flex-start;
            }

            .brand {
                font-size: 12px;
                letter-spacing: 0.1em;
            }

            .eyebrow {
                text-align: right;
            }

            .hero {
                padding: 70px 0 34px;
            }

            .workspace {
                grid-template-columns: 1fr;
            }

            .footer {
                align-items: flex-start;
                flex-direction: column;
                margin-top: 44px;
            }

            .footer-words {
                justify-content: flex-start;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: 1ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 1ms !important;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <div class="shell">
            <header class="brandbar">
                <a class="brand" href="{{ url('/') }}">
                    <span class="brand-mark" aria-hidden="true"></span>
                    <span>Task Manager</span>
                </a>
                <p class="eyebrow">Your self-service workspace</p>
            </header>

            @yield('content')

            <footer class="footer">
                <p class="footer-note">Plan thoughtfully. Make progress cheerfully.</p>
                <div class="footer-words" aria-label="Task Manager features">
                    <span>Tasks</span><span>Focus</span><span>Progress</span>
                </div>
            </footer>
        </div>
    </main>
</body>
</html>
