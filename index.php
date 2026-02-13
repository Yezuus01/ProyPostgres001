<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestión de Estudiantes</title>
    <link rel="stylesheet" href="misestilos.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Menú Principal</h2>
            <p>Gestión de Estudiantes</p>
        </div>
        <nav>
            <ul class="sidebar-nav">
                <li>
                    <a href="index.php" class="active">
                        <i class="fas fa-home"></i>
                        Inicio
                    </a>
                </li>
                <li>
                    <a href="MostrarEstudiantes.php">
                        <i class="fas fa-list"></i>
                        Ver Estudiantes
                    </a>
                </li>
                <li>
                    <a href="AdicionarEstudiantes.php">
                        <i class="fas fa-user-plus"></i>
                        Adicionar Estudiante
                    </a>
                </li>
                <li>
                    <a href="ModificarEstudiantes.php">
                        <i class="fas fa-edit"></i>
                        Modificar Estudiante
                    </a>
                </li>
                <li>
                    <a href="EliminarEstudiantes.php">
                        <i class="fas fa-trash-alt"></i>
                        Eliminar Estudiante
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- HEADER -->
        <div class="header">
            <div>
                <h1><i class="fas fa-graduation-cap"></i> Dashboard</h1>
            </div>
            <div class="header-info">
                <p><strong>Bienvenido al Sistema</strong></p>
                <p>Gestión Integral de Estudiantes</p>
            </div>
        </div>

        <!-- STATS CARDS -->
        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3>Total de Estudiantes</h3>
                <p>150</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-check-circle"></i>
                <h3>Activos</h3>
                <p>145</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-exclamation-circle"></i>
                <h3>Por Revisar</h3>
                <p>5</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-calendar"></i>
                <h3>Actualizados Hoy</h3>
                <p>12</p>
            </div>
        </div>

        <!-- MAIN CARDS -->
        <h2 class="cards-title">Acciones Rápidas</h2>
        <div class="cards-container">
            <a href="MostrarEstudiantes.php" class="card">
                <div class="card-icon">
                    <i class="fas fa-list"></i>
                </div>
                <h3 class="card-title">Ver Estudiantes</h3>
                <p class="card-description">Visualiza la lista completa de todos los estudiantes registrados en el sistema.</p>
                <button class="card-button">Ir</button>
            </a>

            <a href="AdicionarEstudiantes.php" class="card">
                <div class="card-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3 class="card-title">Adicionar Estudiante</h3>
                <p class="card-description">Registra un nuevo estudiante en el sistema con todos sus datos completos.</p>
                <button class="card-button">Ir</button>
            </a>

            <a href="ModificarEstudiantes.php" class="card">
                <div class="card-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <h3 class="card-title">Modificar Estudiante</h3>
                <p class="card-description">Actualiza la información de un estudiante existente en el sistema.</p>
                <button class="card-button">Ir</button>
            </a>

            <a href="EliminarEstudiantes.php" class="card">
                <div class="card-icon">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <h3 class="card-title">Eliminar Estudiante</h3>
                <p class="card-description">Elimina los registros de estudiantes que ya no están en el sistema.</p>
                <button class="card-button">Ir</button>
            </a>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>&copy; 2026 Sistema de Gestión de Estudiantes. Todos los derechos reservados.</p>
        </div>
    </main>
</body>
</html>
