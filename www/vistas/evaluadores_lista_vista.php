
<script src="../librerias/visjs/vis-network.min.js"></script>

<div id="network"></div>

<script>
    // Ejemplo de datos extraídos de tu consulta SQL
    const data = <?php echo json_encode($rows);?>;

    // Configuración de nodos y aristas
    const nodes = new vis.DataSet();
    const edges = new vis.DataSet();

    // Agrega nodos para formularios y empleados (para evitar duplicados)
    //const formNode = { id: `f-${data[0].id_formulario}`, label: data[0].formulario, shape: 'box' };
    //const empNode = { id: `e-${data[0].id_empleado}`, label: data[0].empleado, shape: 'box' };

    //nodes.add(formNode);
    //nodes.add(empNode);
    const formularios = new Map();
    const evaluadores = new Map();
    const empleados = new Map();
    // Agrega nodos para evaluadores y aristas hacia el formulario y el empleado
    data.forEach(item => {
        const evalNode = { id: `u-${item.id_evaluador}` , label: item.evaluador , shape: 'ellipse' };
        const formNode = { id: `f-${item.id_formulario}`, label: "#" + item.id_formulario +" - "+ item.formulario.substr(0,10), shape: 'box'    ,color:'blue'};
        const empNode =  { id: `e-${item.id_empleado}`  , label: item.empleado  , shape: 'box'    ,color:'green' };
        if(!evaluadores.has(item.id_evaluador)){
            evaluadores.set(item.id_evaluador,true);
            nodes.add(evalNode);
        }
        if(!formularios.has(item.id_formulario)){
            formularios.set(item.id_formulario,true);
            nodes.add(formNode);
        }
        if(!empleados.has(item.id_empleado)){
            empleados.set(item.id_empleado,true);
            nodes.add(empNode);
        }
        
        // Conecta evaluadores al formulario
        //edges.add({ from: `u-${item.id_evaluador}`, to: `f-${item.id_formulario}`, arrows: 'to' });

        // Conecta el formulario al empleado
        //edges.add({ from: `f-${item.id_formulario}`, to: `e-${item.id_empleado}`, arrows: 'to' });

        // Conecta evaluadores al empleado
        edges.add({ from: `u-${item.id_evaluador}`, to: `e-${item.id_empleado}`, arrows: 'to',physics: false, });
        // Conecta empleado al formulario
        edges.add({ from: `e-${item.id_empleado}` , to: `f-${item.id_formulario}`, arrows: 'to' ,physics: false,});
    });

    // Crear el grafo
    const options = {
  manipulation: false,
  height: "90%",
  layout: {
    hierarchical: {
      enabled: true,
      levelSeparation: 100,
    },
  },
  physics: {
    hierarchicalRepulsion: {
      nodeDistance: 100,
    },
  },
};
    const container = document.getElementById('network');
    const network = new vis.Network(container, { nodes, edges }, options);

</script>
<!-- <div id="mynetwork"></div> -->

    <script type="text/javascript">
        /*
      // create an array with nodes
      var nodes = new vis.DataSet([
        { id: 1, label: "node\none", shape: "box", color: "#97C2FC" },
        { id: 2, label: "node\ntwo", shape: "circle", color: "#FFFF00" },
        { id: 3, label: "node\nthree", shape: "diamond", color: "#FB7E81" },
        {
          id: 4,
          label: "node\nfour",
          shape: "dot",
          size: 10,
          color: "#7BE141",
        },
        { id: 5, label: "node\nfive", shape: "ellipse", color: "#6E6EFD" },
        { id: 6, label: "node\nsix", shape: "star", color: "#C2FABC" },
        { id: 7, label: "node\nseven", shape: "triangle", color: "#FFA807" },
        {
          id: 8,
          label: "node\neight",
          shape: "triangleDown",
          color: "#6E6EFD",
        },
      ]);

      // create an array with edges
      var edges = new vis.DataSet([
        { from: 1, to: 8, color: { color: "red" } },
        { from: 1, to: 3, color: "rgb(20,24,200)" },
        {
          from: 1,
          to: 2,
          color: { color: "rgba(30,30,30,0.2)", highlight: "blue" },
        },
        { from: 2, to: 4, color: { inherit: "to" } },
        { from: 2, to: 5, color: { inherit: "from" } },
        { from: 5, to: 6, color: { inherit: "both" } },
        { from: 6, to: 7, color: { color: "#ff0000", opacity: 0.3 } },
        { from: 6, to: 8, color: { opacity: 0.3 } },
      ]);

      // create a network
      var container = document.getElementById("mynetwork");
      var data = {
        nodes: nodes,
        edges: edges,
      };
      var options = {
        nodes: {
          shape: "circle",
        },
      };
      var network = new vis.Network(container, data, options);/* */
    </script>
