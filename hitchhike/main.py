import networkx as nx
import heapq

def dijkstra(graph, start):
    distances = {node: float('inf') for node in graph.nodes}
    distances[start] = 0
    priority_queue = [(0, start)]

    while priority_queue:
        current_distance, current_node = heapq.heappop(priority_queue)

        if current_distance > distances[current_node]:
            continue

        for neighbor, weight in graph[current_node].items():
            distance = current_distance + weight['weight']

            if distance < distances[neighbor]:
                distances[neighbor] = distance
                heapq.heappush(priority_queue, (distance, neighbor))

    return distances

def closest_point_on_route(route, point, distances):
    min_distance = float('inf')
    closest_point = None
    for r in route:
        if distances[r] < min_distance:
            min_distance = distances[r]
            closest_point = r
    return closest_point

def find_closest_driver(graph, driver_routes, start, destination):
    hitchhiker_distances = dijkstra(graph, start)
    destination_distances = dijkstra(graph, destination)

    best_driver = None
    best_distance = float('inf')

    for route in driver_routes:
        closest_start = closest_point_on_route(route, start, hitchhiker_distances)
        closest_end = closest_point_on_route(route, destination, destination_distances)

        if closest_start is not None and closest_end is not None:
            distance = (hitchhiker_distances[closest_start] +
                        destination_distances[closest_end])

            if distance < best_distance:
                best_distance = distance
                best_driver = route

    return best_driver, best_distance

# Example usage
G = nx.DiGraph()
# Add edges to the graph (node1, node2, weight)
edges = [
    ('A', 'B', 1), ('B', 'C', 2), ('C', 'D', 1),
    ('A', 'E', 5), ('E', 'D', 2)
]
G.add_weighted_edges_from(edges)

# Define driver routes (list of nodes each driver will visit)
driver_routes = [
    ['A', 'B', 'C', 'D'],
    ['A', 'E', 'D']
]

start = 'A'
destination = 'D'

best_driver, best_distance = find_closest_driver(G, driver_routes, start, destination)

print(f"Best driver route: {best_driver}")
print(f"Total distance: {best_distance}")
