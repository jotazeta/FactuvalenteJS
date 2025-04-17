<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drag and Drop</title>
    <style>
        .draggable {
            width: 200px;
            height: 100px;
            margin: 10px;
            background-color: #9333ea;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: grab;
        }

        .dropzone {
            width: 100%;
            min-height: 300px;
            border: 2px dashed #9333ea;
            display: flex;
            flex-wrap: wrap;
            padding: 10px;
        }

        .drag-over {
            background-color: #f3e8ff;
        }
    </style>
</head>
<body>
    <div class="dropzone" id="dropzone">
        <div class="draggable" draggable="true" id="div1">Div 1</div>
        <div class="draggable" draggable="true" id="div2">Div 2</div>
        <div class="draggable" draggable="true" id="div3">Div 3</div>
    </div>

    <script>
        const draggables = document.querySelectorAll('.draggable');
        const dropzone = document.getElementById('dropzone');

        let draggedElement = null;

        // Add event listeners to draggable elements
        draggables.forEach(draggable => {
            draggable.addEventListener('dragstart', (e) => {
                draggedElement = e.target;
                e.target.style.opacity = '0.5';
            });

            draggable.addEventListener('dragend', (e) => {
                e.target.style.opacity = '1';
                draggedElement = null;
            });
        });

        // Add event listeners to the dropzone
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault(); // Allow dropping
            dropzone.classList.add('drag-over');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('drag-over');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('drag-over');
            if (draggedElement) {
                dropzone.appendChild(draggedElement); // Move the dragged element to the dropzone
            }
        });
    </script>
</body>
</html>