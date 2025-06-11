<form role="search" method="get" class="search-form d-flex align-items-center" action="<?php echo home_url('/'); ?>">
    <label for="search-field" class="visually-hidden">Buscar:</label>
    <input 
        type="search" 
        id="search-field" 
        class="search-field form-control me-2" 
        placeholder="Buscar noticias..." 
        value="<?php echo get_search_query(); ?>" 
        name="s" 
        aria-label="Buscar"
    />
    <button type="submit" class="btn btn-primary">Buscar</button>
</form>