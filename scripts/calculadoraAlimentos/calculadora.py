import json
import mysql.connector 								# Connect to SQL database
from mysql.connector 		import errorcode 		# SQL database error management
from measurement.utils 		import guess 			# To guess a measure: for example guess(2, 'cm') -> Distance(m=0.02)
from measurement.base 		import MeasureBase 		# To create custom measures: Peso, Volumen, Unidad 
from measurement.measures 	import Time

SQLstarted = False

# Inicia el cliente SQL si no ha sido iniciado ya, o lo apaga si recibe False como parámetro.
def beginSQL (bool_start: bool=True):
	global SQLstarted
	global cnx
	global cursor

	try:
		SQLstarted = bool(SQLstarted)
	except:
		SQLstarted = False

	if (not SQLstarted):
		# SQL Connector
		cnx = mysql.connector.connect(user='lasgemelas', password='gemelasaljerez', database='web_gemelasaljerez')
		cursor = cnx.cursor(buffered=True)
		SQLstarted = True
	elif (bool_start == False):
		cursor.close()
		cnx.close()
		SQLstarted = False

# Measures
# UNIDADES_PESO 	= ["kg", "hg", "dag", "g", "dg", "cg", "mg"] 
# UNIDADES_VOLUMEN 	= ["kl", "hl", "dal", "l", "dl", "cl", "ml", "us_cup", "us_tbsp", "us_tsp"]  

class Unidad (MeasureBase):
	STANDARD_UNIT = 'u'
	UNITS = {
		'u': 		1.0,
		'ud':		1.0,
		'uds':		1.0,
		'unidad':	1.0,
		'unidades':	1.0
	}

	ALIAS = {
		'u':		'u',
		'ud':		'u',
		'uds':		'u',
		'unidad':	'u',
		'unidades':	'u',
	}

	#SI_UNITS = ['u']


class Volumen (MeasureBase):
	STANDARD_UNIT = 'l'
	UNITS = {
		'kl': 		1000,
		'hl':		100,
		'dal':		10,
		'l':		1.0,
		'dl':		0.1,
		'cl':		0.01,
		'ml':		0.001,
		'vaso':		0.2,
		'us_cup':	0.236588,
		'us_tbsp': 	0.0147868,
		'us_tsp': 	0.00492892,
	}

	ALIAS = {
		# Units
		'kl': 		'kl',
		'hl':		'hl',
		'dal':		'dal',
		'l':		'l',
		'dl':		'dl',
		'cl':		'cl',
		'ml':		'ml',
		'vaso':		'vaso',
		'us_cup':	'us_cup',
		'us_tbsp': 	'us_tbsp',
		'us_tsp': 	'us_tsp',
		
		# Singular
		'kilolitro':	'kl',
		'hectolitro':	'hl',
		'decalitro':	'dal',
		'litro':		'l',
		'decilitro':	'dl',
		'centilitro':	'cl',
		'mililitro':	'ml',
		'vaso':			'vaso',
        'taza':			'taza',
        'cucharada':	'cucharada',
        'cucharadita':	'cucharadita',

        # Plural
		'kilolitros':	'kl',
		'hectolitros':	'hl',
		'decalitros':	'dal',
		'litros':		'l',
		'decilitros':	'dl',
		'centilitros':	'cl',
		'mililitros':	'ml',
		'vasos':		'vaso',
        'tazas':		'taza',
        'cucharadas':	'cucharada',
        'cucharaditas':	'cucharadita',
	}
	SI_UNITS = ['l']

class Peso(MeasureBase):
    STANDARD_UNIT = 'g'
    UNITS = {
    	'kg': 	0.001,
    	'hg':	0.01,
    	'dag':	0.1,
        'g': 	1.0,
        'dg': 	10.0,
        'cg': 	100.0,
        'mg':	1000.0,
    }

    ALIAS = {
    	# Units
    	'kg':			'kg',
    	'hg':			'hg',
    	'dag':			'dag',
    	'g':			'g',
    	'dg':			'dg',
    	'cg':			'cg',
    	'mg':			'mg',

    	# Singular
        'kilogramo': 	'kg',
        'hectogramo': 	'hg',
        'decagramo': 	'dag',
        'gramo': 		'g',
        'decigramo':	'dg',
        'centigramo':	'cg',
        'miligramo':	'mg',


        # Plural
        'kilogramos': 	'kg',
        'hectogramos': 	'hg',
        'decagramos': 	'dag',
        'gramos': 		'g',
        'decigramos':	'dg',
        'centigramos':	'cg',
        'miligramos':	'mg',
    }
    SI_UNITS = ['g']

UNIDADES_TIEMPO = Time.get_aliases()
UNIDADES_VOLUMEN = Volumen.get_aliases()
UNIDADES_PESO = Peso.get_aliases()
UNIDADES_PESO_VOLUMEN = {**UNIDADES_PESO,  **UNIDADES_VOLUMEN}
MAGNITUDES = [Peso, Volumen, Unidad, Time]




def db_query(columns: str,  table:str, name1:str="", value1:str="", name2:str="", value2:str=""):
	columns = str(columns)
	table 	= str(table)
	name1 	= str(name1)
	name2	= str(name2)
	value1 	= str(value1)
	value2 	= str(value2)

	query = "SELECT " + columns + " FROM " + table

	# Construct query
	if (name1 != ""):
		query += " WHERE " + name1 + "=" + value1
		if (name2 != ""):
			query += " AND " + name2 + "=" + value2

	cursor.execute(query)
	return [cursor.column_names, cursor.fetchall()]




def printProductsInRecipe (id_recipe: int):
	id_recipe = str(id_recipe)
	cursor.execute("SELECT * FROM Producto WHERE id in (SELECT id_producto FROM Receta_Producto WHERE id_receta = " + id_recipe + ")")
	list_products_recipe = cursor.fetchall()
	for producto in list_products_recipe:
		print(producto[1])



def queryToDictionary (cursor):
	list1 = cursor.column_names
	list2 = cursor.fetchall()
	dictionary = []
	for item in list2:
		dictionary.append(dict( zip( list1, item)))
	
	return dictionary


# param & return:
# dic_bebidas = {id_bebida: Unidad(Cantidad+unidad), 5: Unidad(uds=10), 1: Unidad(u=12.0), 7: Unidad(ud=1.0)}
def bebidaToListBebidas (id_bebida: str, cantidad: int, dic_bebidas: dict={}):
	id_bebida = str(id_bebida)
	cantidad  = int(cantidad)
	
	# Opción A: La bebida está en la lista
	if id_bebida in dic_bebidas.keys():
		dic_bebidas[id_bebida] += Unidad(uds=cantidad)
	else:
	# Opción B: La bebida no está en la lista
		dic_bebidas = {**dic_bebidas, id_bebida: Unidad(uds=cantidad)}

	return dic_bebidas


# Nota: productoToListProductos podria reutilizarse para bebida dando a unidad='u'
# param & return:
# dic_productos = {id_producto: Magnitud(Cantidad+unidad), 5: Peso(g=1000.0), 1: Unidad(u=12.0), 7: Volumen(l=1.0)}
def productoToListProductos (id_producto: str, cantidad: int, unidad: str='u', dic_productos: dict={}):
	id_producto = str(id_producto)
	cantidad 	= int(cantidad)
	unidad 		= str(unidad)

	# Opcion A. El producto ya está en la lista.
	if id_producto in dic_productos.keys():
		dic_productos[id_producto] += guess(cantidad, unidad, MAGNITUDES) # Siempre que las magnitudes sean compatibles, la suma no fallará
	else:
	# Opción B. El producto no está en la lista.
		dic_productos = {**dic_productos, id_producto: guess(cantidad, unidad, MAGNITUDES)}

	return dic_productos



# returns:
# dic_productos = {id_producto: Magnitud(Cantidad+unidad), 5: Peso(g=1000.0), 1: Unidad(u=12.0), 7: Volumen(l=1.0)}
def recetaToListProductos (id_receta: str, dic_productos: dict={}):
	id_receta = str(id_receta)

	cursor.execute("SELECT * FROM Receta_Producto WHERE id_receta=" + id_receta)
	dic_RecetaProducto = queryToDictionary(cursor)

	for item in dic_RecetaProducto:
		id_producto  = str(item['id_producto'])
		int_cantidad = int(item['cantidad'])
		str_unidad 	 = str(item['unidad']).lower()

		dic_productos = productoToListProductos(id_producto, int_cantidad, str_unidad, dic_productos)

	return dic_productos




# param & return:
# dic_compra = {
# 	"bebidas": {id: cantidad, 5: 2, 4:1}, 
# 	"productos": {id: Magnitud(Cantidad+Unidad), 2: Peso(g=2), 5: Volumen(ml=34), 7: Unidad(u=2)}
# }
def menuToListCompra (id_menu: str, dic_compra: dict={}):
	id_menu = str(id_menu)
	
	if 'bebidas' in dic_compra.keys():
		dic_bebidas = dic_compra['bebidas']
	else:
		dic_bebidas = {}

	if 'productos' in dic_compra.keys():
		dic_productos = dic_compra['productos']
	else:
		dic_productos = {}


	# ¿Qué bebidas y en qué cantidades están asociadas al menú?
	cursor.execute("SELECT * FROM Menu_Bebida WHERE id_menu=" + id_menu)
	dic_MenuBebida = queryToDictionary(cursor)

	# Acumular bebidas asociadas al menu
	for bebida in dic_MenuBebida:
		dic_bebidas = bebidaToListBebidas(bebida['id_bebida'], bebida['cantidad'], dic_bebidas)

	# Consultar las recetas asociadas a un menú
	cursor.execute("SELECT * FROM Menu_Receta WHERE id_menu=" + id_menu)
	dic_MenuReceta = queryToDictionary(cursor)

	# Para cada receta del menú, agrupar los ingredientes
	for receta in dic_MenuReceta:
		id_receta = str(receta['id_receta'])
		dic_productos = recetaToListProductos(id_receta, dic_productos)

	# Crear la lista de la compra (bebidas + productos)
	return {"bebidas": dic_bebidas, "productos": dic_productos}



# returns:
# dic_compra = {
# 	"bebidas": {id: cantidad, 5: 2, 4:1}, 
# 	"productos": {id: Magnitud(Cantidad+Unidad), 2: Peso(g=2), 5: Volumen(ml=34), 7: Unidad(u=2)},
# 	"materiales": {id: cantidad, 5: 2, 4:1},
# 	"trabajadores": {id: horas}
# }
def eventoToListCompra (id_evento: str, dic_compra: dict={}):
	id_evento = str(id_evento)

	if 'bebidas' in dic_compra.keys():
		dic_bebidas = dic_compra['bebidas']
	else:
		dic_bebidas = {}

	if 'productos' in dic_compra.keys():
		dic_productos = dic_compra['productos']
	else:
		dic_productos = {}

	if 'materiales' in dic_compra.keys():
		dic_materiales = dic_compra['materiales']
	else:
		dic_materiales = {}

	if 'trabajadores' in dic_compra.keys():
		dic_trabajadores = dic_compra['trabajadores']
	else:
		dic_trabajadores = {}


# ¿Hay bebidas asociadas al evento?
	cursor.execute("SELECT * FROM Bebida_Evento WHERE id_evento=" + id_evento)
	dic_BebidaEvento = queryToDictionary(cursor)

	# Acumular bebidas del evento
	for bebida in dic_BebidaEvento:
		dic_bebidas = bebidaToListBebidas(bebida['id_bebida'], bebida['cantidad'], dic_bebidas)

# ¿Cuántos menús hay en el evento?
	cursor.execute("SELECT * FROM Menu_Evento WHERE id_evento=" + id_evento)
	dic_MenuEvento = queryToDictionary(cursor)

	dic_compra = {'bebidas': dic_bebidas, 'productos': dic_productos}

	# Para cada menú del evento...
	for menu in dic_MenuEvento:
		id_menu = str(menu['id_menu'])
		# Acumular ingredientes y bebidas
		for i in range(0, menu['cantidad']): # Menu x cantidad
			dic_compra = menuToListCompra(id_menu, dic_compra)

# ¿Cuántos materiales son usados en el evento?
	cursor.execute("SELECT * FROM Material_Evento WHERE id_evento=" + id_evento)
	dic_MaterialEvento = queryToDictionary(cursor)

	# Acumular materiales
	for material in dic_MaterialEvento:
		id_material  = str(material['id_material'])
		int_cantidad = int(material['cantidad']); # Por restriccion de la bd, este campo es int

		# Opción A: El material ya está en la lista
		if id_material in dic_materiales.keys():
			dic_materiales['id_material'] += Unidad(uds=int_cantidad)
		else:
		# Opción B: El material no está en la lista
			dic_materiales = {**dic_materiales, id_material: Unidad(uds=int_cantidad)}

# ¿Cuántos horas de trabajadores son usadas en el evento?
	cursor.execute("SELECT * FROM Trabajador_Evento WHERE id_evento=" + id_evento)
	dic_Trabajador_Evento = queryToDictionary(cursor)

	# Acumular trabajadores
	for trabajador in dic_Trabajador_Evento:
		id_trabajador  = str(trabajador['id_trabajador'])
		float_cantidad = float(trabajador['horas']); # Por restriccion de la bd, este campo es float

		# Opción A: El trabajador ya está en la lista
		if id_trabajador in dic_trabajadores.keys():
			dic_trabajadores['id_trabajador'] += Unidad(uds=float_cantidad)
		else:
		# Opción B: El trabajador no está en la lista
			dic_trabajadores = {**dic_trabajadores, id_trabajador: Unidad(uds=float_cantidad)}



	dic_compra = {**dic_compra, 'materiales': dic_materiales, 'trabajadores': dic_trabajadores}

	return dic_compra




# param:
# 	dic_compra = {
# 		"bebidas": {id: cantidad, 5: 2, 4:1}, e
# 		"productos": {id: Magnitud(Cantidad+Unidad), 2: Peso(g=2), 5: Volumen(ml=34), 7: Unidad(u=2)}
# 	}
def printDictCompra (dic_compra: dict):
	float_gastos = 0.0

	if 'bebidas' in dic_compra.keys():
		dic_bebidas = dic_compra['bebidas']
	else:
		dic_bebidas = {}

	if 'productos' in dic_compra.keys():
		dic_productos = dic_compra['productos']
	else:
		dic_productos = {}

	# Comprobar que haya bebidas, si las hay, las imprime
	if dic_bebidas:
		print("\t--- Bebidas ---")
		print("Nombre\t\tCantidad\tPrecio_Unidad\tTotal")
		for id_bebida in dic_bebidas:
			cursor.execute("SELECT * FROM Bebida WHERE id=" + str(id_bebida))
			dic_Bebida  = queryToDictionary(cursor)[0]

			str_nombre 	 = str(dic_Bebida['nombre'])
			str_precio_u = str(dic_Bebida['precio_unitario']) 
			flo_cantidad = getattr(dic_bebidas[id_bebida], 'u')
			str_cantidad = str(flo_cantidad)
			float_total  = flo_cantidad * dic_Bebida['precio_unitario']
			str_total 	 = str(float_total)
			float_gastos += float_total

			print(str_nombre + '\t' + str_cantidad + '\t\t' + str_precio_u + '\t\t' + str_total)

	# Comprobar que haya productos, si los hay, los imprime
	if dic_productos:
		print ("\n\t--- Productos ---")
		print("Nombre\t\t\tCantidad\tUnidad\t\tPrecio_Unidad\tTotal")
		for id_producto in dic_productos:
			cursor.execute("SELECT * FROM Producto WHERE id=" + str(id_producto))
			dic_Producto = queryToDictionary(cursor)[0]

			str_nombre   = str(dic_Producto['nombre'])
			str_unidad 	 = str(dic_Producto['unidad'])
			str_precio_u = str(dic_Producto['precio_unitario'])
			flo_cantidad = getattr(dic_productos[id_producto], str_unidad)
			str_cantidad = str(flo_cantidad)
			float_total  = flo_cantidad * dic_Producto['precio_unitario']
			str_total    = str(float_total)
			float_gastos += float_total

			print(str_nombre + '\t\t' + str_cantidad + '\t\t' + str_unidad + '\t\t' + str_precio_u + '\t\t' + str_total)

	print("Gastos: \t" + str(float_gastos) + ' €')



# Guardar un json
def guardarJSON (str_nombre: str, dic_diccionario: dict):
	str_nombre = str(str_nombre) + '.json'

	with open (str_nombre, 'w') as json_file:
		json.dump(dic_diccionario, json_file)
	json_file.close()

# Note: 
# p = menuToListCompra(2)['productos']
# for i in p:
# 	print (i)
# 	print (p[i]) 	
# >>> id: 1
# >>> measure: 1.0 unidad
