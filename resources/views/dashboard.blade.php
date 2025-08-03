<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("¡Aquí pondremos algo! ¿Número de colmenas y estadísticas?") }}
                </div>
                <div class="p-6 text-gray-600">
                    {{ __("Tambien estoy pensando en cambiar el logo por un girasol") }}    
                </div>
                <div class="p-6 text-gray-600">
                    {{ __("Conocimiento poner info relevante") }}    
                </div>
                <div class="p-6 text-gray-600">
                    {{ __("Calendario para programar eventos, o que te diga cosas utiles dependiendo de que temporada sea") }}    
                </div>
                <div class="p-6 text-gray-600">
                    {{ __("Falta comprobar funcionalidad de todos los campos (algunos no deben ser editables y creados por sistema p ej slug) para pasar al diseño visual de cada seccion") }}    
                </div>
                <div class="p-6 text-gray-600">
                    {{ __("Ya existe la mayoria de datos en la base, pero faltan los controladores para CRUD (Create Read Update Delete) de las reynas, inspecciones y eventos.") }}    
                </div>


                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Usuarios</h2>
                    <ul class="list-disc pl-6 mb-6">
                        <li><strong>Superadmin:</strong> Para configuración del sitio, etc.</li>
                        <li><strong>Admin/User:</strong> Usuario principal que solicita el servicio y tiene acceso total.</li>
                        <li><strong>User/Staff:</strong> Usuario secundario con acceso limitado, configurable por el admin.</li>
                    </ul>

                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Colmena</h2>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Id, Nombre, Slug, QRcode</li>
                        <li>Calificación (0-100)</li>
                        <li>Tags (personalizados por usuario)</li>
                        <li>Tipo de colmena: Langstroth, Dadant, Layens, Top-Bar, Warre, Flow</li>
                        <li>Fecha de nacimiento de colmena</li>
                        <li>
                            <strong>Reyna</strong>
                            <ul class="list-disc pl-6">
                                <li>Raza</li>
                                <li>Fecha de introducción</li>
                                <li>Edad</li>
                            </ul>
                        </li>
                        <li>Ubicación</li>
                        <li>
                            <strong>Estado de la colmena:</strong> Desconocido, Activa, Invernando, Enjambrazón, Despoblada, Huérfana, Zanganera, En formación, Revisión, Mantenimiento, Alimentación Artificial, Crianza de reinas, Pillaje, Pillera, Unión, Sin uso.
                        </li>
                        <li>Notas de colmena</li>
                        <li>
                            <strong>Historial de reinas</strong>
                            <ul class="list-disc pl-6">
                                <li>Fecha de cambio</li>
                                <li>Motivo</li>
                                <li>Notas</li>
                                <li>Reyna</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Historial de inspecciones</strong>
                            <ul class="list-disc pl-6">
                                <li>Fecha</li>
                                <li>Estado de la reina</li>
                                <li>Población</li>
                                <li>Recursos
                                    <ul class="list-disc pl-6">
                                        <li>Miel</li>
                                        <li>Polen</li>
                                        <li>Cría</li>
                                    </ul>
                                </li>
                                <li>Comportamiento</li>
                                <li>Plagas o enfermedades</li>
                                <li>Tratamientos</li>
                                <li>Notas generales</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Historial de eventos</strong>
                            <ul class="list-disc pl-6">
                                <li>Cosechas de miel: cantidad y fecha</li>
                                <li>Alimentación artificial</li>
                                <li>División de colmena</li>
                                <li>Unificación de colmena</li>
                                <li>Sustitución o ingreso de reyna</li>
                                <li>Tratamiento</li>
                            </ul>
                        </li>
                        <li>
                            <strong>Apiarios</strong>
                            <ul class="list-disc pl-6">
                                <li>Grupo de colmenas</li>
                                <li>Ubicación</li>
                                <li>Fecha de creación</li>
                                <li>Otros datos relevantes</li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
