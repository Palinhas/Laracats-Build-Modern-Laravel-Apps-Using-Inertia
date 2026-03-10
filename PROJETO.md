# Projeto Esteticista — Contexto para IA

## Sobre o Projeto

Aplicação web para gestão de um salão de estética com **um único utilizador** (a esteticista).
Futuramente os clientes poderão tornar-se utilizadores da aplicação.

---

## Stack Tecnológica

| Tecnologia | Versão | Notas |
|---|---|---|
| PHP | 8.4 | |
| Laravel | 12 | |
| Inertia.js | v2 | `@inertiajs/vue3` |
| Vue 3 | última | Composition API + `<script setup>` |
| Tailwind CSS | v4 | Sem `tailwind.config.js` |
| DaisyUI | v5 | Plugin nativo do Tailwind v4 |
| Heroicons | v2 | `@heroicons/vue` |
| Lodash | última | Só para `debounce` |
| Autenticação | Laravel Breeze | Instalado com `--no-ssr` |
| Build | Vite | Sem SSR, sem Wayfinder, sem TypeScript |
| Linguagem Frontend | JavaScript | Não usar TypeScript |

---

## Instalação do Projeto

```powershell
composer create-project laravel/laravel estetica
cd estetica
composer require laravel/breeze --dev
php artisan breeze:install vue --no-ssr
npm install
npm install daisyui
npm install @heroicons/vue
npm install lodash
php artisan migrate
npm run dev
```

---

## Configuração DaisyUI v5 — `resources/css/app.css`

```css
@import 'tailwindcss';
@plugin "daisyui" {
    themes: light --default, dark --prefers-color-scheme;
}
```

---

## Módulos da Aplicação

### Clientes
- `id`, `nome`, `email`, `telefone`, `data_nascimento`, `notas`

### Fichas de Cliente
- `id`, `cliente_id`, `data`, `tratamento`, `observações`, `próxima_visita`

### Marcações
- `id`, `cliente_id`, `data`, `hora`, `tratamento`, `estado` (pendente / confirmado / cancelado)

---

## Convenções e Boas Práticas Definidas

### Vue 3
- Usar sempre `<script setup>` — **nunca** misturar com `export default`
- Para remover layout numa página usar `defineOptions({ layout: null })`
- Registar componentes globais no `app.js` (ex: `Link`, `Layout`)
- Importar ícones individualmente: `import { MagnifyingGlassIcon } from "@heroicons/vue/24/outline"`

### Inertia
- Usar `router.get()` em vez do antigo `Inertia.get()` (`@inertiajs/inertia` está deprecated)
- Usar `useForm` para todos os formulários — nunca `ref` para forms
- Usar `preserveState: true` e `replace: true` em pesquisas
- Usar `preserve-scroll` na paginação
- Partilhar dados globais via `HandleInertiaRequests` middleware (ex: `auth.user`)

### Laravel
- Usar `through()` em vez de `select()` para transformar dados antes de enviar ao frontend
- Usar `when()` para filtros opcionais nas queries
- Password encriptada automaticamente via cast `'password' => 'hashed'` no Model `User`
- Usar `User::class` em vez de strings para policies/gates
- Validação sempre com `$request->validate()`
- Sem `throttle` em rotas CRUD — só em login/forgot-password

### CSS / DaisyUI v5
- Classes de erro nos inputs: `input-error` + `fieldset-label text-error`
- Estrutura de form: `fieldset` > `legend.fieldset-legend` > `input` > `p.fieldset-label`
- Botão com loading: `btn` + `:disabled="form.processing"` + `loading loading-spinner`

### Git
- Remote via HTTPS (não SSH)
- PowerShell usa `;` para separar comandos (não `&&`)

---

## Estrutura de Pastas Vue

```
resources/js/
├── app.js                  # Registo global de componentes e layout padrão
├── Components/
│   ├── Layout.vue          # Layout principal com navbar
│   ├── Navbar.vue          # Navegação
│   ├── Pagination.vue      # Recebe :links (array), não o objeto completo
│   └── Icon.vue            # Componente de ícones SVG custom (alternativa heroicons)
└── Pages/
    ├── Auth/
    │   └── Login.vue       # defineOptions({ layout: null })
    └── Users/
        ├── Index.vue
        └── Create.vue
```

---

## app.js — Layout Global

```js
import Layout from "@/Components/Layout.vue";

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        let page = pages[`./Pages/${name}.vue`]
        if (page.default.layout === undefined) {
            page.default.layout = Layout
        }
        return page
    },
})
```

> ⚠️ Usar `=== undefined` e **não** `??` — o `??` substitui `null` e quebra o `defineOptions({ layout: null })`

---

## Padrão de Pesquisa com Debounce

```js
// Vue (Pages/Users/Index.vue)
import { router } from "@inertiajs/vue3"
import { ref, watch } from "vue"
import debounce from "lodash/debounce"

const props = defineProps({ users: Object, filters: Object })
const search = ref(props.filters.search)

watch(search, debounce((value) => {
    router.get('/users', { search: value }, { preserveState: true, replace: true })
}, 300))
```

```php
// Laravel (routes/web.php)
User::when(request('search'), fn($query, $search) =>
    $query->where('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%")
)->paginate(10)
 ->withQueryString()
 ->through(fn($user) => [
     'id' => $user->id,
     'name' => $user->name,
     'email' => $user->email,
 ])
```

---

## Padrão de Formulário com useForm

```vue
<script setup>
import { useForm, Head } from "@inertiajs/vue3"

const form = useForm({ name: '', email: '' })

const submit = () => {
    form.post('/rota', {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
    <form @submit.prevent="submit">
        <fieldset class="fieldset">
            <legend class="fieldset-legend">Nome</legend>
            <input v-model="form.name" type="text" class="input w-full"
                   :class="{ 'input-error': form.errors.name }" />
            <p v-if="form.errors.name" class="fieldset-label text-error">
                {{ form.errors.name }}
            </p>
        </fieldset>
        <button class="btn btn-neutral" :disabled="form.processing">
            <span v-if="form.processing" class="loading loading-spinner loading-sm"></span>
            {{ form.processing ? 'A guardar...' : 'Guardar' }}
        </button>
    </form>
</template>
```

---

## Notas Importantes

- **Sem TypeScript** — projeto em JavaScript puro
- **Sem SSR** — aplicação SPA
- **Sem Wayfinder** — rotas definidas manualmente como strings
- **Sem throttle em CRUD** — só em autenticação
- **DaisyUI v5** usa `@plugin` nativo do Tailwind v4, sem `tailwind.config.js`
- O programador é português — responder sempre em **português**
- Não fazer alterações sem autorização explícita

