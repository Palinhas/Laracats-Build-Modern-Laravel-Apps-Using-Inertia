# Inertia Demo — Laravel 12 + Inertia.js + Vue 3

Projeto de estudo baseado no curso **"Build Modern Laravel Apps Using Inertia.js"** da Laracasts, atualizado para 2026.

## Stack

- **Backend:** Laravel 12
- **Frontend:** Vue 3 (Composition API + `<script setup>`)
- **SPA:** Inertia.js v2
- **CSS:** Tailwind CSS v4 + DaisyUI v5
- **Icons:** Heroicons v2 (`@heroicons/vue`)
- **Build:** Vite

## Funcionalidades

- ✅ Listagem de utilizadores com paginação
- ✅ Pesquisa em tempo real com debounce (lodash)
- ✅ Criação de utilizadores com validação server-side
- ✅ Layout persistente com Inertia
- ✅ Página de Login sem layout
- ✅ Proteção de rotas com middleware `can`

## Instalação

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
```

## Aprendizagens

- Inertia.js como ponte entre Laravel e Vue 3 sem API REST
- `useForm` para gestão de formulários com erros de validação
- `router.get()` com `preserveState` e `replace` para pesquisa
- Layout global no `app.js` com `defineOptions({ layout: null })` para exceções
- `through()` para transformar dados antes de enviar ao frontend
- `defineOptions` em vez de `export default` no `<script setup>`
