<?php
require_once 'config.php';

// Check if admin is logged in
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$entity = $_GET['entity'] ?? '';
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? 0;

function getRequestData() {
    $data = json_decode(file_get_contents('php://input'), true);
    if (empty($data)) {
        $data = $_POST;
    }
    return $data;
}

try {
    switch ($entity) {
        case 'hero_slides': handleHeroSlides($method, $action, $id); break;
        case 'services': handleServices($method, $action, $id); break;
        case 'brands': handleBrands($method, $action, $id); break;
        case 'clients': handleClients($method, $action, $id); break;
        case 'testimonials': handleTestimonials($method, $action, $id); break;
        case 'faqs': handleFaqs($method, $action, $id); break;
        case 'messages': handleMessages($method, $action, $id); break;
        case 'settings': handleSettings($method, $action, $id); break;
        case 'stats': handleStats($method, $action, $id); break;
        case 'about': handleAbout($method, $action, $id); break;
        case 'contact_info': handleContactInfo($method, $action, $id); break;
        case 'sectors': handleSectors($method, $action, $id); break;
        case 'products': handleProducts($method, $action, $id); break;
        case 'profile': handleProfile($method, $action, $id); break;
        case 'upload': handleUpload(); break;
        default:
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Entity not found']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

// ----------------------------------------------------------------------
// HANDLERS
// ----------------------------------------------------------------------

function handleHeroSlides($method, $action, $id) {
    global $conn;
    
    if ($action === 'toggle_status') {
        $stmt = $conn->prepare("UPDATE hero_slides SET is_active = NOT is_active WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        logActivity($conn, 'toggle_hero_slide', "Toggled hero slide #$id");
        echo json_encode(['success' => true]);
        return;
    }
    
    if ($action === 'update_order') {
        $data = getRequestData();
        foreach ($data['items'] as $index => $itemId) {
            $stmt = $conn->prepare("UPDATE hero_slides SET sort_order = ? WHERE id = ?");
            $stmt->bind_param('ii', $index, $itemId);
            $stmt->execute();
        }
        echo json_encode(['success' => true]);
        return;
    }
    
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $conn->prepare("SELECT * FROM hero_slides WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $result = $stmt->get_result();
                echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
            } else {
                $result = $conn->query("SELECT * FROM hero_slides ORDER BY sort_order ASC");
                $items = [];
                while ($row = $result->fetch_assoc()) { $items[] = $row; }
                echo json_encode(['success' => true, 'data' => $items]);
            }
            break;
        case 'POST':
            $data = getRequestData();
            $stmt = $conn->prepare("INSERT INTO hero_slides (title, subtitle, description, image_url, cta_text, cta_link, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $sortRes = $conn->query("SELECT COALESCE(MAX(sort_order),0)+1 as next FROM hero_slides");
            $sort = $sortRes ? $sortRes->fetch_assoc()['next'] : 1;
            
            $title = $data['title'] ?? '';
            $subtitle = $data['subtitle'] ?? '';
            $desc = $data['description'] ?? '';
            $img = $data['image_url'] ?? '';
            $cta = $data['cta_text'] ?? '';
            $link = $data['cta_link'] ?? '';
            
            $stmt->bind_param('ssssssi', $title, $subtitle, $desc, $img, $cta, $link, $sort);
            $stmt->execute();
            logActivity($conn, 'create_hero_slide', "Created hero slide: {$title}");
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
            break;
        case 'PUT':
            $data = getRequestData();
            $stmt = $conn->prepare("UPDATE hero_slides SET title=?, subtitle=?, description=?, image_url=?, cta_text=?, cta_link=? WHERE id=?");
            $title = $data['title'] ?? '';
            $subtitle = $data['subtitle'] ?? '';
            $desc = $data['description'] ?? '';
            $img = $data['image_url'] ?? '';
            $cta = $data['cta_text'] ?? '';
            $link = $data['cta_link'] ?? '';
            
            $stmt->bind_param('ssssssi', $title, $subtitle, $desc, $img, $cta, $link, $id);
            $stmt->execute();
            logActivity($conn, 'update_hero_slide', "Updated hero slide #$id");
            echo json_encode(['success' => true]);
            break;
        case 'DELETE':
            $stmt = $conn->prepare("DELETE FROM hero_slides WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            logActivity($conn, 'delete_hero_slide', "Deleted hero slide #$id");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleServices($method, $action, $id) {
    global $conn;
    
    if ($action === 'toggle_status') {
        $stmt = $conn->prepare("UPDATE services SET is_active = NOT is_active WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        logActivity($conn, 'toggle_service', "Toggled service #$id");
        echo json_encode(['success' => true]);
        return;
    }
    
    if ($action === 'update_order') {
        $data = getRequestData();
        foreach ($data['items'] as $index => $itemId) {
            $stmt = $conn->prepare("UPDATE services SET sort_order = ? WHERE id = ?");
            $stmt->bind_param('ii', $index, $itemId);
            $stmt->execute();
        }
        echo json_encode(['success' => true]);
        return;
    }
    
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $conn->prepare("SELECT * FROM services WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                echo json_encode(['success' => true, 'data' => $stmt->get_result()->fetch_assoc()]);
            } else {
                $result = $conn->query("SELECT * FROM services ORDER BY sort_order ASC");
                $items = [];
                while ($row = $result->fetch_assoc()) { $items[] = $row; }
                echo json_encode(['success' => true, 'data' => $items]);
            }
            break;
        case 'POST':
            $data = getRequestData();
            $stmt = $conn->prepare("INSERT INTO services (title, description, icon_class, image_url, sort_order) VALUES (?, ?, ?, ?, ?)");
            $sortRes = $conn->query("SELECT COALESCE(MAX(sort_order),0)+1 as next FROM services");
            $sort = $sortRes ? $sortRes->fetch_assoc()['next'] : 1;
            
            $title = $data['title'] ?? '';
            $desc = $data['description'] ?? '';
            $icon = $data['icon_class'] ?? '';
            $img = $data['image_url'] ?? '';
            
            $stmt->bind_param('ssssi', $title, $desc, $icon, $img, $sort);
            $stmt->execute();
            logActivity($conn, 'create_service', "Created service: $title");
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
            break;
        case 'PUT':
            $data = getRequestData();
            $stmt = $conn->prepare("UPDATE services SET title=?, description=?, icon_class=?, image_url=? WHERE id=?");
            $title = $data['title'] ?? '';
            $desc = $data['description'] ?? '';
            $icon = $data['icon_class'] ?? '';
            $img = $data['image_url'] ?? '';
            
            $stmt->bind_param('ssssi', $title, $desc, $icon, $img, $id);
            $stmt->execute();
            logActivity($conn, 'update_service', "Updated service #$id");
            echo json_encode(['success' => true]);
            break;
        case 'DELETE':
            $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            logActivity($conn, 'delete_service', "Deleted service #$id");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleBrands($method, $action, $id) {
    global $conn;
    
    if ($action === 'toggle_status') {
        $stmt = $conn->prepare("UPDATE brands SET is_active = NOT is_active WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        logActivity($conn, 'toggle_brand', "Toggled brand #$id");
        echo json_encode(['success' => true]);
        return;
    }
    
    if ($action === 'update_order') {
        $data = getRequestData();
        foreach ($data['items'] as $index => $itemId) {
            $stmt = $conn->prepare("UPDATE brands SET sort_order = ? WHERE id = ?");
            $stmt->bind_param('ii', $index, $itemId);
            $stmt->execute();
        }
        echo json_encode(['success' => true]);
        return;
    }
    
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $conn->prepare("SELECT * FROM brands WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                echo json_encode(['success' => true, 'data' => $stmt->get_result()->fetch_assoc()]);
            } else {
                $result = $conn->query("SELECT * FROM brands ORDER BY sort_order ASC");
                $items = [];
                while ($row = $result->fetch_assoc()) { $items[] = $row; }
                echo json_encode(['success' => true, 'data' => $items]);
            }
            break;
        case 'POST':
            $data = getRequestData();
            $stmt = $conn->prepare("INSERT INTO brands (name, image_url, link, sort_order) VALUES (?, ?, ?, ?)");
            $sortRes = $conn->query("SELECT COALESCE(MAX(sort_order),0)+1 as next FROM brands");
            $sort = $sortRes ? $sortRes->fetch_assoc()['next'] : 1;
            
            $name = $data['name'] ?? '';
            $img = $data['image_url'] ?? '';
            $link = $data['link'] ?? '';
            
            $stmt->bind_param('sssi', $name, $img, $link, $sort);
            $stmt->execute();
            logActivity($conn, 'create_brand', "Created brand: $name");
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
            break;
        case 'PUT':
            $data = getRequestData();
            $stmt = $conn->prepare("UPDATE brands SET name=?, image_url=?, link=? WHERE id=?");
            $name = $data['name'] ?? '';
            $img = $data['image_url'] ?? '';
            $link = $data['link'] ?? '';
            
            $stmt->bind_param('sssi', $name, $img, $link, $id);
            $stmt->execute();
            logActivity($conn, 'update_brand', "Updated brand #$id");
            echo json_encode(['success' => true]);
            break;
        case 'DELETE':
            $stmt = $conn->prepare("DELETE FROM brands WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            logActivity($conn, 'delete_brand', "Deleted brand #$id");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleClients($method, $action, $id) {
    global $conn;
    
    if ($action === 'toggle_status') {
        $stmt = $conn->prepare("UPDATE clients SET is_active = NOT is_active WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        logActivity($conn, 'toggle_client', "Toggled client #$id");
        echo json_encode(['success' => true]);
        return;
    }
    
    if ($action === 'update_order') {
        $data = getRequestData();
        foreach ($data['items'] as $index => $itemId) {
            $stmt = $conn->prepare("UPDATE clients SET sort_order = ? WHERE id = ?");
            $stmt->bind_param('ii', $index, $itemId);
            $stmt->execute();
        }
        echo json_encode(['success' => true]);
        return;
    }
    
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                echo json_encode(['success' => true, 'data' => $stmt->get_result()->fetch_assoc()]);
            } else {
                $result = $conn->query("SELECT * FROM clients ORDER BY sort_order ASC");
                $items = [];
                while ($row = $result->fetch_assoc()) { $items[] = $row; }
                echo json_encode(['success' => true, 'data' => $items]);
            }
            break;
        case 'POST':
            $data = getRequestData();
            $stmt = $conn->prepare("INSERT INTO clients (name, image_url, link, sort_order) VALUES (?, ?, ?, ?)");
            $sortRes = $conn->query("SELECT COALESCE(MAX(sort_order),0)+1 as next FROM clients");
            $sort = $sortRes ? $sortRes->fetch_assoc()['next'] : 1;
            
            $name = $data['name'] ?? '';
            $img = $data['image_url'] ?? '';
            $link = $data['link'] ?? '';
            
            $stmt->bind_param('sssi', $name, $img, $link, $sort);
            $stmt->execute();
            logActivity($conn, 'create_client', "Created client: $name");
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
            break;
        case 'PUT':
            $data = getRequestData();
            $stmt = $conn->prepare("UPDATE clients SET name=?, image_url=?, link=? WHERE id=?");
            $name = $data['name'] ?? '';
            $img = $data['image_url'] ?? '';
            $link = $data['link'] ?? '';
            
            $stmt->bind_param('sssi', $name, $img, $link, $id);
            $stmt->execute();
            logActivity($conn, 'update_client', "Updated client #$id");
            echo json_encode(['success' => true]);
            break;
        case 'DELETE':
            $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            logActivity($conn, 'delete_client', "Deleted client #$id");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleTestimonials($method, $action, $id) {
    global $conn;
    
    if ($action === 'toggle_status') {
        $stmt = $conn->prepare("UPDATE testimonials SET is_active = NOT is_active WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        logActivity($conn, 'toggle_testimonial', "Toggled testimonial #$id");
        echo json_encode(['success' => true]);
        return;
    }
    
    if ($action === 'update_order') {
        $data = getRequestData();
        foreach ($data['items'] as $index => $itemId) {
            $stmt = $conn->prepare("UPDATE testimonials SET sort_order = ? WHERE id = ?");
            $stmt->bind_param('ii', $index, $itemId);
            $stmt->execute();
        }
        echo json_encode(['success' => true]);
        return;
    }
    
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $conn->prepare("SELECT * FROM testimonials WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                echo json_encode(['success' => true, 'data' => $stmt->get_result()->fetch_assoc()]);
            } else {
                $result = $conn->query("SELECT * FROM testimonials ORDER BY sort_order ASC");
                $items = [];
                while ($row = $result->fetch_assoc()) { $items[] = $row; }
                echo json_encode(['success' => true, 'data' => $items]);
            }
            break;
        case 'POST':
            $data = getRequestData();
            $stmt = $conn->prepare("INSERT INTO testimonials (client_name, client_position, content, image_url, sort_order) VALUES (?, ?, ?, ?, ?)");
            $sortRes = $conn->query("SELECT COALESCE(MAX(sort_order),0)+1 as next FROM testimonials");
            $sort = $sortRes ? $sortRes->fetch_assoc()['next'] : 1;
            
            $name = $data['client_name'] ?? '';
            $pos = $data['client_position'] ?? '';
            $content = $data['content'] ?? '';
            $img = $data['image_url'] ?? '';
            
            $stmt->bind_param('ssssi', $name, $pos, $content, $img, $sort);
            $stmt->execute();
            logActivity($conn, 'create_testimonial', "Created testimonial by $name");
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
            break;
        case 'PUT':
            $data = getRequestData();
            $stmt = $conn->prepare("UPDATE testimonials SET client_name=?, client_position=?, content=?, image_url=? WHERE id=?");
            $name = $data['client_name'] ?? '';
            $pos = $data['client_position'] ?? '';
            $content = $data['content'] ?? '';
            $img = $data['image_url'] ?? '';
            
            $stmt->bind_param('ssssi', $name, $pos, $content, $img, $id);
            $stmt->execute();
            logActivity($conn, 'update_testimonial', "Updated testimonial #$id");
            echo json_encode(['success' => true]);
            break;
        case 'DELETE':
            $stmt = $conn->prepare("DELETE FROM testimonials WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            logActivity($conn, 'delete_testimonial', "Deleted testimonial #$id");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleFaqs($method, $action, $id) {
    global $conn;
    
    if ($action === 'toggle_status') {
        $stmt = $conn->prepare("UPDATE faqs SET is_active = NOT is_active WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        logActivity($conn, 'toggle_faq', "Toggled FAQ #$id");
        echo json_encode(['success' => true]);
        return;
    }
    
    if ($action === 'update_order') {
        $data = getRequestData();
        foreach ($data['items'] as $index => $itemId) {
            $stmt = $conn->prepare("UPDATE faqs SET sort_order = ? WHERE id = ?");
            $stmt->bind_param('ii', $index, $itemId);
            $stmt->execute();
        }
        echo json_encode(['success' => true]);
        return;
    }
    
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $conn->prepare("SELECT * FROM faqs WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                echo json_encode(['success' => true, 'data' => $stmt->get_result()->fetch_assoc()]);
            } else {
                $result = $conn->query("SELECT * FROM faqs ORDER BY sort_order ASC");
                $items = [];
                while ($row = $result->fetch_assoc()) { $items[] = $row; }
                echo json_encode(['success' => true, 'data' => $items]);
            }
            break;
        case 'POST':
            $data = getRequestData();
            $stmt = $conn->prepare("INSERT INTO faqs (question, answer, sort_order) VALUES (?, ?, ?)");
            $sortRes = $conn->query("SELECT COALESCE(MAX(sort_order),0)+1 as next FROM faqs");
            $sort = $sortRes ? $sortRes->fetch_assoc()['next'] : 1;
            
            $question = $data['question'] ?? '';
            $answer = $data['answer'] ?? '';
            
            $stmt->bind_param('ssi', $question, $answer, $sort);
            $stmt->execute();
            logActivity($conn, 'create_faq', "Created FAQ");
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
            break;
        case 'PUT':
            $data = getRequestData();
            $stmt = $conn->prepare("UPDATE faqs SET question=?, answer=? WHERE id=?");
            $question = $data['question'] ?? '';
            $answer = $data['answer'] ?? '';
            
            $stmt->bind_param('ssi', $question, $answer, $id);
            $stmt->execute();
            logActivity($conn, 'update_faq', "Updated FAQ #$id");
            echo json_encode(['success' => true]);
            break;
        case 'DELETE':
            $stmt = $conn->prepare("DELETE FROM faqs WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            logActivity($conn, 'delete_faq', "Deleted FAQ #$id");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleMessages($method, $action, $id) {
    global $conn;
    
    if ($action === 'mark_read') {
        $stmt = $conn->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo json_encode(['success' => true]);
        return;
    }
    
    if ($action === 'mark_all_read') {
        $conn->query("UPDATE messages SET is_read = 1 WHERE is_read = 0");
        echo json_encode(['success' => true]);
        return;
    }
    
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $conn->prepare("SELECT * FROM messages WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                echo json_encode(['success' => true, 'data' => $stmt->get_result()->fetch_assoc()]);
            } else {
                $result = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
                $items = [];
                while ($row = $result->fetch_assoc()) { $items[] = $row; }
                echo json_encode(['success' => true, 'data' => $items]);
            }
            break;
        case 'DELETE':
            $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            logActivity($conn, 'delete_message', "Deleted message #$id");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleSettings($method, $action, $id) {
    global $conn;
    
    switch ($method) {
        case 'GET':
            $result = $conn->query("SELECT * FROM settings");
            $items = [];
            while ($row = $result->fetch_assoc()) { 
                $items[$row['setting_key']] = $row['setting_value']; 
            }
            echo json_encode(['success' => true, 'data' => $items]);
            break;
        case 'PUT':
            $data = getRequestData();
            foreach ($data as $key => $value) {
                $stmt = $conn->prepare("UPDATE settings SET setting_value=? WHERE setting_key=?");
                $stmt->bind_param('ss', $value, $key);
                $stmt->execute();
            }
            logActivity($conn, 'update_settings', "Updated site settings");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleStats($method, $action, $id) {
    global $conn;
    
    if ($action === 'toggle_status') {
        $stmt = $conn->prepare("UPDATE stats SET is_active = NOT is_active WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        logActivity($conn, 'toggle_stat', "Toggled stat #$id");
        echo json_encode(['success' => true]);
        return;
    }
    
    if ($action === 'update_order') {
        $data = getRequestData();
        foreach ($data['items'] as $index => $itemId) {
            $stmt = $conn->prepare("UPDATE stats SET sort_order = ? WHERE id = ?");
            $stmt->bind_param('ii', $index, $itemId);
            $stmt->execute();
        }
        echo json_encode(['success' => true]);
        return;
    }
    
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $conn->prepare("SELECT * FROM stats WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                echo json_encode(['success' => true, 'data' => $stmt->get_result()->fetch_assoc()]);
            } else {
                $result = $conn->query("SELECT * FROM stats ORDER BY sort_order ASC");
                $items = [];
                while ($row = $result->fetch_assoc()) { $items[] = $row; }
                echo json_encode(['success' => true, 'data' => $items]);
            }
            break;
        case 'POST':
            $data = getRequestData();
            $stmt = $conn->prepare("INSERT INTO stats (title, value, icon_class, sort_order) VALUES (?, ?, ?, ?)");
            $sortRes = $conn->query("SELECT COALESCE(MAX(sort_order),0)+1 as next FROM stats");
            $sort = $sortRes ? $sortRes->fetch_assoc()['next'] : 1;
            
            $title = $data['title'] ?? '';
            $value = $data['value'] ?? '';
            $icon = $data['icon_class'] ?? '';
            
            $stmt->bind_param('sssi', $title, $value, $icon, $sort);
            $stmt->execute();
            logActivity($conn, 'create_stat', "Created stat: $title");
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
            break;
        case 'PUT':
            $data = getRequestData();
            $stmt = $conn->prepare("UPDATE stats SET title=?, value=?, icon_class=? WHERE id=?");
            $title = $data['title'] ?? '';
            $value = $data['value'] ?? '';
            $icon = $data['icon_class'] ?? '';
            
            $stmt->bind_param('sssi', $title, $value, $icon, $id);
            $stmt->execute();
            logActivity($conn, 'update_stat', "Updated stat #$id");
            echo json_encode(['success' => true]);
            break;
        case 'DELETE':
            $stmt = $conn->prepare("DELETE FROM stats WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            logActivity($conn, 'delete_stat', "Deleted stat #$id");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleAbout($method, $action, $id) {
    global $conn;
    
    switch ($method) {
        case 'GET':
            $result = $conn->query("SELECT * FROM about_content LIMIT 1");
            echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
            break;
        case 'PUT':
            $data = getRequestData();
            $stmt = $conn->prepare("UPDATE about_content SET title=?, subtitle=?, content=?, image_url=?, mission=?, vision=? WHERE id=1");
            
            $title = $data['title'] ?? '';
            $subtitle = $data['subtitle'] ?? '';
            $content = $data['content'] ?? '';
            $img = $data['image_url'] ?? '';
            $mission = $data['mission'] ?? '';
            $vision = $data['vision'] ?? '';
            
            $stmt->bind_param('ssssss', $title, $subtitle, $content, $img, $mission, $vision);
            $stmt->execute();
            logActivity($conn, 'update_about', "Updated about section");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleContactInfo($method, $action, $id) {
    global $conn;
    
    switch ($method) {
        case 'GET':
            $result = $conn->query("SELECT * FROM contact_info LIMIT 1");
            echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
            break;
        case 'PUT':
            $data = getRequestData();
            $stmt = $conn->prepare("UPDATE contact_info SET address=?, email=?, phone=?, phone2=?, map_embed=?, working_hours=?, facebook=?, twitter=?, instagram=?, linkedin=? WHERE id=1");
            
            $addr = $data['address'] ?? '';
            $email = $data['email'] ?? '';
            $phone = $data['phone'] ?? '';
            $phone2 = $data['phone2'] ?? '';
            $map = $data['map_embed'] ?? '';
            $hours = $data['working_hours'] ?? '';
            $fb = $data['facebook'] ?? '';
            $tw = $data['twitter'] ?? '';
            $ig = $data['instagram'] ?? '';
            $li = $data['linkedin'] ?? '';
            
            $stmt->bind_param('ssssssssss', $addr, $email, $phone, $phone2, $map, $hours, $fb, $tw, $ig, $li);
            $stmt->execute();
            logActivity($conn, 'update_contact_info', "Updated contact info");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleSectors($method, $action, $id) {
    global $conn;
    
    if ($action === 'toggle_status') {
        $stmt = $conn->prepare("UPDATE sectors SET is_active = NOT is_active WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        logActivity($conn, 'toggle_sector', "Toggled sector #$id");
        echo json_encode(['success' => true]);
        return;
    }
    
    if ($action === 'update_order') {
        $data = getRequestData();
        foreach ($data['items'] as $index => $itemId) {
            $stmt = $conn->prepare("UPDATE sectors SET sort_order = ? WHERE id = ?");
            $stmt->bind_param('ii', $index, $itemId);
            $stmt->execute();
        }
        echo json_encode(['success' => true]);
        return;
    }
    
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $conn->prepare("SELECT * FROM sectors WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                echo json_encode(['success' => true, 'data' => $stmt->get_result()->fetch_assoc()]);
            } else {
                $result = $conn->query("SELECT * FROM sectors ORDER BY sort_order ASC");
                $items = [];
                while ($row = $result->fetch_assoc()) { $items[] = $row; }
                echo json_encode(['success' => true, 'data' => $items]);
            }
            break;
        case 'POST':
            $data = getRequestData();
            $stmt = $conn->prepare("INSERT INTO sectors (title, description, image_url, sort_order) VALUES (?, ?, ?, ?)");
            $sortRes = $conn->query("SELECT COALESCE(MAX(sort_order),0)+1 as next FROM sectors");
            $sort = $sortRes ? $sortRes->fetch_assoc()['next'] : 1;
            
            $title = $data['title'] ?? '';
            $desc = $data['description'] ?? '';
            $img = $data['image_url'] ?? '';
            
            $stmt->bind_param('sssi', $title, $desc, $img, $sort);
            $stmt->execute();
            logActivity($conn, 'create_sector', "Created sector: $title");
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
            break;
        case 'PUT':
            $data = getRequestData();
            $stmt = $conn->prepare("UPDATE sectors SET title=?, description=?, image_url=? WHERE id=?");
            $title = $data['title'] ?? '';
            $desc = $data['description'] ?? '';
            $img = $data['image_url'] ?? '';
            
            $stmt->bind_param('sssi', $title, $desc, $img, $id);
            $stmt->execute();
            logActivity($conn, 'update_sector', "Updated sector #$id");
            echo json_encode(['success' => true]);
            break;
        case 'DELETE':
            $stmt = $conn->prepare("DELETE FROM sectors WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            logActivity($conn, 'delete_sector', "Deleted sector #$id");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleProducts($method, $action, $id) {
    global $conn;
    
    if ($action === 'toggle_status') {
        $stmt = $conn->prepare("UPDATE products SET is_active = NOT is_active WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        logActivity($conn, 'toggle_product', "Toggled product #$id");
        echo json_encode(['success' => true]);
        return;
    }
    
    if ($action === 'update_order') {
        $data = getRequestData();
        foreach ($data['items'] as $index => $itemId) {
            $stmt = $conn->prepare("UPDATE products SET sort_order = ? WHERE id = ?");
            $stmt->bind_param('ii', $index, $itemId);
            $stmt->execute();
        }
        echo json_encode(['success' => true]);
        return;
    }
    
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();
                echo json_encode(['success' => true, 'data' => $stmt->get_result()->fetch_assoc()]);
            } else {
                $sector_id = $_GET['sector_id'] ?? 0;
                if ($sector_id) {
                    $stmt = $conn->prepare("SELECT * FROM products WHERE sector_id = ? ORDER BY sort_order ASC");
                    $stmt->bind_param('i', $sector_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                } else {
                    $result = $conn->query("SELECT p.*, s.title as sector_title FROM products p LEFT JOIN sectors s ON p.sector_id = s.id ORDER BY p.sort_order ASC");
                }
                $items = [];
                while ($row = $result->fetch_assoc()) { $items[] = $row; }
                echo json_encode(['success' => true, 'data' => $items]);
            }
            break;
        case 'POST':
            $data = getRequestData();
            $stmt = $conn->prepare("INSERT INTO products (title, description, image_url, sector_id, sort_order) VALUES (?, ?, ?, ?, ?)");
            $sortRes = $conn->query("SELECT COALESCE(MAX(sort_order),0)+1 as next FROM products");
            $sort = $sortRes ? $sortRes->fetch_assoc()['next'] : 1;
            
            $title = $data['title'] ?? '';
            $desc = $data['description'] ?? '';
            $img = $data['image_url'] ?? '';
            $sector_id = $data['sector_id'] ?? 0;
            
            $stmt->bind_param('sssii', $title, $desc, $img, $sector_id, $sort);
            $stmt->execute();
            logActivity($conn, 'create_product', "Created product: $title");
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
            break;
        case 'PUT':
            $data = getRequestData();
            $stmt = $conn->prepare("UPDATE products SET title=?, description=?, image_url=?, sector_id=? WHERE id=?");
            $title = $data['title'] ?? '';
            $desc = $data['description'] ?? '';
            $img = $data['image_url'] ?? '';
            $sector_id = $data['sector_id'] ?? 0;
            
            $stmt->bind_param('sssii', $title, $desc, $img, $sector_id, $id);
            $stmt->execute();
            logActivity($conn, 'update_product', "Updated product #$id");
            echo json_encode(['success' => true]);
            break;
        case 'DELETE':
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            logActivity($conn, 'delete_product', "Deleted product #$id");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleProfile($method, $action, $id) {
    global $conn;
    $admin_id = $_SESSION['admin_id'] ?? 1;
    
    switch ($method) {
        case 'GET':
            $stmt = $conn->prepare("SELECT id, username, email, full_name, role, created_at FROM users WHERE id = ?");
            $stmt->bind_param('i', $admin_id);
            $stmt->execute();
            echo json_encode(['success' => true, 'data' => $stmt->get_result()->fetch_assoc()]);
            break;
        case 'PUT':
            $data = getRequestData();
            $email = $data['email'] ?? '';
            $full_name = $data['full_name'] ?? '';
            $old_password = $data['old_password'] ?? '';
            $new_password = $data['new_password'] ?? '';
            
            // Check old password if updating password
            if (!empty($new_password)) {
                $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
                $stmt->bind_param('i', $admin_id);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                
                if (!password_verify($old_password, $user['password'])) {
                    echo json_encode(['success' => false, 'message' => 'Invalid old password']);
                    return;
                }
                
                $hash = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET email=?, full_name=?, password=? WHERE id=?");
                $stmt->bind_param('sssi', $email, $full_name, $hash, $admin_id);
                $stmt->execute();
            } else {
                $stmt = $conn->prepare("UPDATE users SET email=?, full_name=? WHERE id=?");
                $stmt->bind_param('ssi', $email, $full_name, $admin_id);
                $stmt->execute();
            }
            
            logActivity($conn, 'update_profile', "Admin updated profile");
            echo json_encode(['success' => true]);
            break;
    }
}

function handleUpload() {
    if (!isset($_FILES['file'])) {
        echo json_encode(['success' => false, 'message' => 'No file uploaded']);
        return;
    }
    
    $file = $_FILES['file'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    
    if ($file['size'] > $maxSize) {
        echo json_encode(['success' => false, 'message' => 'File size exceeds 5MB limit']);
        return;
    }
    
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($file['type'], $allowedTypes) || !in_array($ext, $allowedExts)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type']);
        return;
    }
    
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    $subDir = isset($_GET['type']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['type']) . '/' : '';
    if ($subDir && !is_dir($uploadDir . $subDir)) {
        mkdir($uploadDir . $subDir, 0777, true);
    }
    
    $fileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '', basename($file['name']));
    $targetPath = $uploadDir . $subDir . $fileName;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $url = 'uploads/' . $subDir . $fileName;
        echo json_encode(['success' => true, 'url' => $url]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
    }
}
